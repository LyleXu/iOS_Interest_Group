//
//  DataLayer.m
//  GTCCLibrary
//
//  Created by Lyle on 7/26/12.
//  Copyright (c) 2012 __MyCompanyName__. All rights reserved.
//

#import "DataLayer.h"
#import "SBJson.h"
#import "CBook.h"
#define ServiceAddress @"http://localhost/~Lyle/gtcclibrary/amfphp/index.php"

@implementation DataLayer

+ (NSString*) GetJsonString:(NSString*)serviceName 
                     methodName:(NSString*)methodName 
                     parameters:(NSArray*)parameters
{
    
    NSDictionary *jsonDictionary = [NSDictionary dictionaryWithObjectsAndKeys:
                                    [NSString stringWithString:serviceName], @"serviceName",
                                    [NSString stringWithString:methodName], @"methodName",
                                    [NSArray arrayWithArray:parameters], @"parameters", 
                                    nil];
    
    NSString *jsonString = [jsonDictionary JSONRepresentation];
    return jsonString;
}

+ (NSDictionary*) FetchData:(NSString*)serviceName 
                    methodName:(NSString*)methodName 
                    parameters:(NSArray*)parameters
{
    NSError *theError = nil;   
   
    NSString* jsonString = [self GetJsonString:serviceName methodName:methodName parameters:parameters];
    
    NSData *jsonData = [jsonString dataUsingEncoding:NSUTF8StringEncoding];
    
    NSMutableURLRequest *request = [NSMutableURLRequest requestWithURL:[NSURL URLWithString:ServiceAddress]];
    [request setValue:@"application/json; charset=utf-8" forHTTPHeaderField:@"Content-Type"];
    [request setHTTPMethod:@"POST"];
    [request setHTTPBody:jsonData];
    NSURLResponse *theResponse =[[NSURLResponse alloc]init];
    NSData *data = [NSURLConnection sendSynchronousRequest:request returningResponse:&theResponse error:&theError];      
    NSMutableString *theString = [[[NSString alloc] initWithData:data encoding:NSUTF8StringEncoding] copy];
    NSDictionary *jsonDictionaryResponse = [theString JSONValue];
    return jsonDictionaryResponse;
}

+(id) GetValueByKey:(NSDictionary*) dictionary 
                keyName:(NSString*) keyName
{
    NSArray *keys;
    int i, count;
    id key, value;
    
    keys = [dictionary allKeys];
    count = [keys count];
    for (i = 0; i < count; i++)
    {
        key = [keys objectAtIndex: i];
        if([key isEqual:keyName])
        {
            value = [dictionary objectForKey: key];
            return value;
        }
    }
    return nil;

}

+ (BOOL)Login:(NSString*)userName
        password:(NSString*)password
{
    NSArray* parameters = [NSArray arrayWithObjects: userName, password, nil];
    NSDictionary* result = [self FetchData:@"LoginService" methodName:@"Login" parameters:parameters];
    NSInteger value = [[self GetValueByKey:result keyName:@"_returnCode"] integerValue];
    if(value == 0)
    {
        return true;
    }else
    {
        return false;
    }
}

//Array of CBook
+ (NSMutableArray*) GetAllBooks
{    
    NSDictionary* result = [self FetchData:@"BookService" methodName:@"GetAllBooks" parameters:nil];
    NSDictionary* datas = [self GetValueByKey:result keyName:@"Books"];
    
    NSMutableArray *AllBooks = [NSMutableArray array];
    
    for (NSDictionary *data in [datas allValues]) {
		CBook* book = [CBook new];
        [book Parse:data];
		[AllBooks addObject:book];
	}
    
    return [AllBooks copy];
}

@end
