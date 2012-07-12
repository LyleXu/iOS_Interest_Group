<?php

namespace Json;

/*
 * MoXie (SysTem128@GMail.Com) 2010-12-11 
 *
 * Copyright &copy; 2010-2010 Zoeey.Org
 * Code license: GNU Lesser General Public License Version 3
 * http://www.gnu.org/licenses/lgpl-3.0.txt
 *
 * website:
 * http://code.google.com/p/json-schema-php/
 */

/**
 * JSON Schema generate/validate
 * 
 * @author moxie(system128@gmail.com)
 */
class JsonSchema {

    /**
     * JSON
     *
     * @var string
     */
    private $json;
    /**
     * Last error
     * 
     * @var array
     */
    private $errors;
    /**
     * Extend types
     *
     * @var map
     */
    private $complexTypes;

    /**
     *
     * @param string $json
     */
    function __construct($json) {
        $this->errors = array();
        $this->complexTypes = array();
        $this->json = json_decode($json);
    }

    /**
     * Generate JSON Schema
     *
     * @return string JSON Schema
     */
    public function getSchema() {
        $schema = null;
        $schema = $this->genByType($this->json);
        return json_encode($schema);
    }

    /**
     * Generate JSON Schema by type
     * @param mixed $value
     * @return object
     */
    private function genByType($value) {
        $type = gettype($value);
        $schema = array();
        switch ($type) {
            case 'boolean':
                $schema['type'] = 'boolean';
                $schema['default'] = false;
                break;
            case 'integer':
                $schema['type'] = 'integer';
                $schema['default'] = 0;
                $schema['minimum'] = 0;
                $schema['maximum'] = PHP_INT_MAX;
                $schema['exclusiveMinimum'] = 0;
                $schema['exclusiveMaximum'] = PHP_INT_MAX;
                break;
            case 'double':
                $schema['type'] = 'number';
                $schema['default'] = 0;
                $schema['minimum'] = 0;
                $schema['maximum'] = PHP_INT_MAX;
                $schema['exclusiveMinimum'] = 0;
                $schema['exclusiveMaximum'] = PHP_INT_MAX;
                break;
            case 'string':
                $schema['type'] = 'string';
                $schema['format'] = 'regex';
                $schema['pattern'] = '/^[a-z0-9]+$/i';
                $schema['minLength'] = 0;
                $schema['maxLength'] = PHP_INT_MAX;
                break;
            case 'array':
                $schema['type'] = 'array';
                $schema['minItems'] = 0;
                $schema['maxItems'] = 20;
                $items = array();
                foreach ($value as $value) {
                    $items = $this->genByType($value);
                    break;
                }
                $schema['items'] = $items;
                break;
            case 'object':
                $schema['type'] = 'object';
                $items = array();
                $value = get_object_vars($value);
                foreach ($value as $key => $value) {
                    $items[$key] = $this->genByType($value);
                }
                $schema['properties'] = $items;
                break;
            case 'null': // any in union types
                $schema['type'] = 'null';
                break;
            default:
                break;
        }
        return $schema;
    }

    /**
     * Set type schema
     * @param string $typeSchema
     */
    public function addType($typeSchema) {
        if (empty($typeSchema)) {
            return;
        }
        $typeSchema = json_decode($typeSchema, true);
        if (is_array($typeSchema) && isset($typeSchema['id'])) {
            $this->complexTypes[$typeSchema['id']] = $typeSchema;
        }
    }

    /**
     * Get type schema
     *
     * @param string ref
     * @return string schema
     */
    private function getType($ref) {
        if (isset($this->complexTypes[$ref])) {
            return $this->complexTypes[$ref];
        }
        return null;
    }

    /**
     * Validate JSON
     *
     * @param string $schema JSON Schema
     * @return boolean
     */
    public function validate($schema) {
        $isVali = false;
        do {
            $schema = json_decode($schema, true);
            if (!is_array($schema) || !isset($schema['type'])) {
                $this->addError('schema parse error. (PHP 5 >= 5.3.0) see json_last_error(void).');
                break;
            }
            $isVali = $this->checkByType($this->json, $schema);
        } while (false);
        return $isVali;
    }

    /**
     * check type: string
     * http://tools.ietf.org/html/draft-zyp-json-schema-03#section-5.1
     * 
     * @param string $value
     * @param array $schema
     */
    private function checkString($value, $schema) {
        // string
        $isVali = false;
        do {

            if (!is_string($value)) {
                $this->addError(sprintf('value: "%s" is not a string.', $value));
                break;
            }
            $len = strlen($value);
            if (isset($schema['minLength'])) {
                if ($schema['minLength'] > $len) {
                    $this->addError(sprintf('value: "%s" is too short.', $value));
                    break;
                }
            }
            if (isset($schema['maxLength'])) {
                if ($schema['maxLength'] < $len) {
                    $this->addError(sprintf('value: "%s" is too long.', $value));
                    break;
                }
            }

            if (isset($schema['format'])) {
                switch ($schema['format']) {

                    case 'date-time':
                        /**
                         * date-time  This SHOULD be a date in ISO 8601 format of YYYY-MM-
                         * DDThh:mm:ssZ in UTC time.  This is the recommended form of date/
                         * timestamp.
                         */
                        break;
                    case 'date':
                        /**
                         * date  This SHOULD be a date in the format of YYYY-MM-DD.  It is
                         * recommended that you use the "date-time" format instead of "date"
                         * unless you need to transfer only the date part.
                         */
                        break;
                    case 'time':
                        /**
                         * time  This SHOULD be a time in the format of hh:mm:ss.  It is
                         * recommended that you use the "date-time" format instead of "time"
                         * unless you need to transfer only the time part.
                         */
                        break;
                    case 'utc-millisec':
                        /**
                         * utc-millisec  This SHOULD be the difference, measured in
                         * milliseconds, between the specified time and midnight, 00:00 of
                         * January 1, 1970 UTC.  The value SHOULD be a number (integer or
                         * float).
                         */
                        break;
                    case 'regex':
                        /**
                         * regex  A regular expression, following the regular expression
                         * specification from ECMA 262/Perl 5.
                         */
                        if (isset($schema['pattern'])) {
                            $pattern = $schema['pattern'];
                            if (preg_match($pattern, $value)) {
                                $isVali = true;
                            } else {
                                $this->addError(printf('"%s" does not match "%s"', $value, $pattern));
                            }
                        } else {
                            $this->addError('format-regex: pattern is undefined.');
                        }

                        break;
                    case 'color':
                        /**
                         * color  This is a CSS color (like "#FF0000" or "red"), based on CSS
                         * 2.1 [W3C.CR-CSS21-20070719].
                         */
                        break;
                    case 'style':
                        /**
                         * style  This is a CSS style definition (like "color: red; background-
                         * color:#FFF"), based on CSS 2.1 [W3C.CR-CSS21-20070719].
                         */
                        break;
                    case 'phone':
                        /**
                         * phone  This SHOULD be a phone number (format MAY follow E.123).
                         * http://en.wikipedia.org/wiki/E.123
                         */
                        if (preg_match("/^(\(0?[0-9]{2}\) \d{3,4}\s?\d{4}|\+\d{2} \d{2} \d{3,4}\s?\d{4})$/", $value)) {
                            $isVali = true;
                        } else {
                            $this->addError(sprintf('value: "%s" is not a phone number.', $value));
                        }
                        break;
                    case 'uri':
                        /**
                         * uri  This value SHOULD be a URI..
                         */
                        if (filter_var($value, FILTER_VALIDATE_URL, FILTER_FLAG_QUERY_REQUIRED)) {
                            $isVali = true;
                        } else {
                            $this->addError(sprintf('value: "%s" is not a URI.', $value));
                        }
                        break;
                    case 'email':
                        /**
                         *  email  This SHOULD be an email address.
                         */
                        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            $isVali = true;
                        } else {
                            $this->addError(sprintf('value: "%s" is not a email.', $value));
                        }
                        break;
                    case 'ip-address':
                        /**
                         *  ip-address  This SHOULD be an ip version 4 address.
                         */
                        if (filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                            $isVali = true;
                        } else {
                            $this->addError(sprintf('value: "%s" is not a ipv4 address.', $value));
                        }

                        break;
                    case 'ipv6':
                        /**
                         *  ipv6  This SHOULD be an ip version 6 address.
                         */
                        if (filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                            $isVali = true;
                        } else {
                            $this->addError(sprintf('value: "%s" is not a ipv6 address.', $value));
                        }
                        break;
                    case 'host-name':
                        /**
                         *  host-name  This SHOULD be a host-name.
                         */
                        break;

                    default:
                        $this->addError(sprintf('format: "%s" is undefined.', $schema['format']));
                        break;
                }
                break;
            }

            $isVali = true;
        } while (false);
        return $isVali;
    }

    /**
     * check type: integer/double
     *
     * @param number $value
     * @param array $schema
     * @return boolean
     */
    private function checkNumber($value, $schema) {
        // number
        $isVali = false;
        do {

            if (!is_numeric($value)) {
                $this->addError($value . ' is not a number.');
                break;
            }
            if (isset($schema['minimum'])) {
                if ($schema['minimum'] > $value) {
                    $this->addError(sprintf('%s is less than %s.', $value, $schema['minimum']));
                    break;
                }
            }
            if (isset($schema['maximum'])) {
                if ($schema['maximum'] < $value) {
                    $this->addError(sprintf('%s is bigger than %s.', $value, $schema['maximum']));
                    break;
                }
            }
            if (isset($schema['exclusiveMinimum'])) {
                if ($schema['exclusiveMinimum'] >= $value) {
                    $this->addError(sprintf('%s is less or than %s or equal.', $value, $schema['exclusiveMinimum']));
                    break;
                }
            }
            if (isset($schema['exclusiveMaximum'])) {
                if ($schema['exclusiveMaximum'] <= $value) {
                    $this->addError(sprintf('%s is bigger than %s or equal.', $value, $schema['exclusiveMaximum']));
                    break;
                }
            }
            $isVali = true;
        } while (false);

        return $isVali;
    }

    /**
     * check type: integer
     *
     * @param integer $value
     * @param array $schema
     * @return boolean
     */
    private function checkInteger($value, $schema) {
        // integer
        if (!is_integer($value)) {
            $this->addError(sprintf('value:"%s" is not a integer.', $value));
            return false;
        }
        return $this->checkNumber($value, $schema);
    }

    /**
     * check type: boolean
     *
     * @param boolean $value
     * @param array $schema
     * @return boolean
     */
    private function checkBoolean($value, $schema) {
        // boolean
        if (!is_bool($value)) {
            $this->addError(sprintf('value: "%s" is not a boolean.', $value));
            return false;
        }
        return true;
    }

    /**
     * check type: object
     *
     * @param object $valueProp
     * @param array $schema
     * @return boolean
     */
    private function checkObject($value, $schema) {
        // object
        $isVali = false;
        do {
            if (!is_object($value)) {
                $this->addError(sprintf('value: "%s" is not an object.', $value));
                break;
            }
            if (isset($schema['properties'])
                    && !empty($schema['properties'])
            ) {
                $schemaProp = $schema['properties'];
                $valueProp = get_object_vars($value);
                $valueKeys = array_keys($valueProp);
                $schemaKeys = array_keys($schemaProp);
                $diffKeys = array_diff($valueKeys, $schemaKeys);
                if (!empty($diffKeys)) {
                    foreach ($diffKeys as $key) {
                        // property not defined / not optional
                        if (!isset($schemaProp[$key])
                                || !isset($schemaProp[$key]['optional'])
                                || !$schemaProp[$key]['optional']
                        ) {
                            $this->addError(sprintf('key: "%s" is not exist,And it\'s not a optional property.', $value));
                            break 2;
                        }
                    }
                }
                foreach ($schemaProp as $key => $sch) {
                    if (!isset($valueProp[$key])) {
                        continue;
                    }
                    if (!$this->checkByType($valueProp[$key], $sch)) {
                        break 2;
                    }
                }
            }
            $isVali = true;
        } while (false);
        return $isVali;
    }

    /**
     * check type: array
     *
     * @param array $value
     * @param array $schema
     * @return boolean 
     */
    private function checkArray($value, $schema) {
        $isVali = false;
        do {
            if (!is_array($value)) {
                $this->addError(sprintf('value: "%s" is not an array.', $value));
                break;
            }

            if (!isset($schema['items'])) {
                $this->addError('schema: items schema is undefined.');
                break;
            }
            $size = count($value);
            if (isset($schema['minItems'])) {
                if ($schema['minItems'] > $size) {
                    $this->addError(sprintf('array size: %s  is less than %s.', $size, $schema['minItems']));
                    break;
                }
            }
            if (isset($schema['maxItems'])) {
                if ($schema['maxItems'] < $size) {
                    $this->addError(sprintf('array size: %s is bigger than %s.', $size, $schema['maxItems']));
                    break;
                }
            }

            foreach ($value as $val) {
                if (!$this->checkByType($val, $schema['items'])) {
                    break 2;
                }
            }


            $isVali = true;
        } while (false);
        return $isVali;
    }

    /**
     * check value based on type
     *
     * @param mixed $value
     * @param array $schema
     * @return boolean
     */
    private function checkByType($value, $schema) {
        $isVali = false;
        if ($schema && isset($schema['type'])) {
            // union types
            if (is_array($schema['type'])) {
                $types = $schema['type'];
                foreach ($types as $type) {
                    $schema['type'] = $type;
                    $isVali = $this->checkByType($value, $schema);
                    if ($isVali) {
                        break;
                    }
                }
            } else {
                $type = $schema['type'];
                switch ($type) {
                    case 'boolean':
                        $isVali = $this->checkBoolean($value, $schema);
                        break;
                    case 'integer':
                        $isVali = $this->checkInteger($value, $schema);
                        break;
                    case 'number':
                        $isVali = $this->checkNumber($value, $schema);
                        break;
                    case 'string':
                        $isVali = $this->checkString($value, $schema);
                        break;
                    case 'array':
                        $isVali = $this->checkArray($value, $schema);
                        break;
                    case 'object':
                        $isVali = $this->checkObject($value, $schema);
                        break;
                    case 'enum':
                        $isVali = is_null($value);
                        break;
                    case 'null':
                        $isVali = is_null($value);
                        break;
                    case 'any':
                        $isVali = true;
                        break;
                    default:
                        $this->addError(sprintf('type_schema: "%s" is undefined.', $value));
                        break;
                }
            }
        }
        if (isset($schema['$ref'])) {
            $isVali = $this->checkByType($value, $this->getType($schema['$ref']));
        }
        return $isVali;
    }

    /**
     *  Get errors
     *
     * @return array errors
     */
    public function getErrors() {
        return $this->errors;
    }

    /**
     * add error message
     * @param string $msg
     */
    protected function addError($msg) {
        $this->errors[] = htmlentities($msg);
    }

}

?>
