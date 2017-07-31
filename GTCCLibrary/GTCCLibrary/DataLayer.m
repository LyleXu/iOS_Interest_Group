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
#import "Constraint.h"
#import "Utility.h"

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
    NSLog(@"%@",jsonString);
    NSData *jsonData = [jsonString dataUsingEncoding:NSUTF8StringEncoding];
    
    NSString* serverURL = [[NSString alloc] initWithFormat:@"%@%@",ServerHost,ServiceAddress];
    NSMutableURLRequest *request = [NSMutableURLRequest requestWithURL:[NSURL URLWithString:serverURL]];
    [request setValue:@"application/json; charset=utf-8" forHTTPHeaderField:@"Content-Type"];
    [request setHTTPMethod:@"POST"];
    [request setHTTPBody:jsonData];
    NSURLResponse *theResponse =[[NSURLResponse alloc]init];
    NSData *data = [NSURLConnection sendSynchronousRequest:request returningResponse:&theResponse error:&theError];      
    NSMutableString *theString = [[[NSString alloc] initWithData:data encoding:NSUTF8StringEncoding] copy];
    NSDictionary *jsonDictionaryResponse = [theString JSONValue];
    return jsonDictionaryResponse;
}

//Array of CBook
+ (NSMutableArray*) GetAllBooks:(NSString*)offset
                       count:(NSString*)count
{
    NSArray* parameters = [NSArray arrayWithObjects: offset, count, nil];
    NSDictionary* result = [self FetchData:@"BookService" methodName:@"GetAllBooks" parameters:parameters];
    NSDictionary* datas = [result valueForKey:@"Books"];
    
    NSMutableArray *AllBooks = [NSMutableArray array];
    
    if([datas count])
    {
        for (NSDictionary *data in [datas allValues]) {
            CBook* book = [CBook new];
            [book Parse:data];
            [AllBooks addObject:book];
        }
    }
    
    return [AllBooks copy];
}

+ (BOOL)Login:(NSString*)userName
        password:(NSString*)password
{
    NSArray* parameters = [NSArray arrayWithObjects: userName, password, nil];
    NSDictionary* result = [self FetchData:@"LoginService" methodName:@"Login" parameters:parameters];
    NSInteger value = [[result valueForKey:@"_returnCode"] integerValue];
    if(value == 0)
    {
        return true;
    }
    else
    {
        return false;
    }
}

+(NSInteger) Borrow:(NSString*) username
        bookBianhao: (NSString*) bookBianhao
{
    NSArray* parameters = [NSArray arrayWithObjects: username, bookBianhao, nil];
    NSDictionary* result = [self FetchData:@"BorrowService" methodName:@"Borrow" parameters:parameters];
    NSInteger value = [[result valueForKey:@"_returnCode"] integerValue];
    return value;
}

+(BOOL) ReturnBook:(NSString*) username
        bookBianhao:(NSString*) bookBianhao
{
    NSArray* parameters = [NSArray arrayWithObjects: username, bookBianhao, nil];
    NSDictionary* result = [self FetchData:@"BorrowService" methodName:@"ReturnBook" parameters:parameters];
    NSInteger value = [[result valueForKey:@"_returnCode"] integerValue];
    if(value == 0)
    {
        return true;
    }else
    {
        return false;
    }
}

+(BOOL) checkWhetherBookInBorrow:(NSString*) bookBianhao
{
    NSArray* parameters = [NSArray arrayWithObjects: bookBianhao, nil];
    NSDictionary* result = [self FetchData:@"BorrowService" methodName:@"checkWhetherBookInBorrow" parameters:parameters];
    NSInteger value = [[result valueForKey:@"_returnCode"] integerValue];
    if(value == 0)
    {
        return true;
    }else
    {
        return false;
    }

}

//NSMutableArray
//+(CBorrowHistory*) getBorrowInfo:(NSString*) username
+(NSMutableArray*) getBorrowInfo:(NSString*) username
{
    NSMutableArray *AllHistoryBooks = [NSMutableArray array];
    NSArray* parameters = [NSArray arrayWithObjects: username, nil];
    NSDictionary* result = [self FetchData:@"BorrowService" methodName:@"getBorrowInfo" parameters:parameters];
    NSDictionary* datas = [result valueForKey:@"borrowInfo"];
    
    if(datas != [NSNull null] )
    {
      for (NSDictionary *data in [datas allValues]) {
		CBorrowHistory* history = [CBorrowHistory new];
        [history Parse:data];
        [AllHistoryBooks addObject:history];
        //return history;
	  }
    }
    
    return AllHistoryBooks;
}



+(NSMutableString*)FetchDataFromWebByGet:(NSString *)url
{
    NSError *theError = nil;   
    NSMutableURLRequest *request = [NSMutableURLRequest requestWithURL:[NSURL URLWithString:url]];
    [request setValue:@"application/json; charset=utf-8" forHTTPHeaderField:@"Content-Type"];
    [request setHTTPMethod:@"GET"];
    NSURLResponse *theResponse =[[NSURLResponse alloc]init];
    NSData *data = [NSURLConnection sendSynchronousRequest:request returningResponse:&theResponse error:&theError];      
    NSMutableString *theString = [[[NSString alloc] initWithData:data encoding:NSUTF8StringEncoding] copy];
    return theString;
}

+(NSMutableString*)FetchDataFromWebByGetByHtml:(NSString *)url
{
    NSError *theError = nil;
    NSMutableURLRequest *request = [NSMutableURLRequest requestWithURL:[NSURL URLWithString:url]];
    [request setValue:@"text/html; charset=utf-8" forHTTPHeaderField:@"Content-Type"];
    [request setHTTPMethod:@"GET"];
    NSURLResponse *theResponse =[[NSURLResponse alloc]init];
    NSData *data = [NSURLConnection sendSynchronousRequest:request returningResponse:&theResponse error:&theError];
    NSMutableString *theString = [[[NSString alloc] initWithData:data encoding:NSUTF8StringEncoding] copy];
    return theString;
}

+(NSInteger)addBookToLibrary:(CBook *)bookInfo
{
    // The first parameter should be bianhao, but not sure we will use it
    NSArray* parameters = [NSArray arrayWithObjects: bookInfo.bianhao,bookInfo.title,bookInfo.author,
                           bookInfo.publisher,bookInfo.publishedDate,@"",bookInfo.printLength,
                           bookInfo.ISBN,bookInfo.price,bookInfo.bookDescription,bookInfo.imageUrl, nil];
    NSDictionary* result = [self FetchData:@"BookService" methodName:@"AddBook" parameters:parameters];
    NSInteger value = [[result valueForKey:@"_returnCode"] integerValue];
    return value;
}

+(NSMutableArray*) getBookListbyISBN:(NSString *)ISBN
{
    NSArray* parameters = [NSArray arrayWithObjects:ISBN, nil];
    NSDictionary* result = [self FetchData:@"BookService" methodName:@"GetBookListByISBN" parameters:parameters];
    
    NSDictionary* datas = [result valueForKey:@"BookList"];
    
    NSMutableArray *bookList = [NSMutableArray array];
    
    if([datas count])
    {
        for (NSDictionary *data in [datas allValues]) {
            CBook* book = [CBook new];
            [book Parse:data];
            [bookList addObject:book];
        }
    }
    
    return [bookList copy];
}

@end
