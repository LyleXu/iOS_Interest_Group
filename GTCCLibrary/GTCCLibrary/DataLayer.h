//
//  DataLayer.h
//  GTCCLibrary
//
//  Created by Lyle on 7/26/12.
//  Copyright (c) 2012 __MyCompanyName__. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "CBorrowHistory.h"

#define DouBanAPI @"http://book.douban.com/isbn/"

@interface DataLayer : NSObject

+(BOOL) Login:(NSString*)userName
password:(NSString*)password;

+(NSMutableArray*) GetAllBooks;
+(BOOL) checkWhetherBookInBorrow:(NSString*) bookBianhao;
+(BOOL) Borrow:(NSString*) username
   bookBianhao: (NSString*) bookBianhao;
+(CBorrowHistory*) getBorrowInfo:(NSString*) username;
+(BOOL) ReturnBook:(NSString*) username
       bookBianhao:(NSString*) bookBianhao;
+(NSMutableString *)FetchDataFromWeb:(NSString* )url;
@end

