If flush() function does not work. You must set next options in php.ini like:

--[code]--
 output_buffering = Off  
 ;output_handler =   
 zlib.output_compression = Off  
 ;zlib.output_handler =   
--[^code^]--

If things does not work you must view headers from the server and check `Server` string.
In my case, as the frontend was Nginx webserver and Apache work as backend.
Accordingly, buffering must be disabled in Nginx config file.
To stop buffering you must add next string to config file:

--[code]--
proxy_buffering off;
--[^code^]--

and restart Nginx daemon.  More information about  configuration you find in documentation on the nginx website.