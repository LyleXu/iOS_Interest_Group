//
//  DataLayer.h
//  GTCCLibrary
//
//  Created by Lyle on 7/26/12.
//  Copyright (c) 2012 __MyCompanyName__. All rights reserved.
//

#import <Foundation/Foundation.h>
#import "CBorrowHistory.h"
#import "CBook.h"
@interface DataLayer : NSObject

+(BOOL) Login:(NSString*)userName
password:(NSString*)password;

+(NSMutableArray*) GetAllBooks:(NSString*)offset
                         count:(NSString*)count;
+(BOOL) checkWhetherBookInBorrow:(NSString*) bookBianhao;
+(NSInteger) Borrow:(NSString*) username
   bookBianhao: (NSString*) bookBianhao;
+(CBorrowHistory*) getBorrowInfo:(NSString*) username;
+(BOOL) ReturnBook:(NSString*) username
       bookBianhao:(NSString*) bookBianhao;
+(NSMutableString *)FetchDataFromWebByGet:(NSString* )url;
+(NSInteger) addBookToLibrary:(CBook*) bookInfo;

typedef enum
{
  BookTagAlreadyExists = -201,
  CannnotBorrowExceeding3 = -303,
}ErrorCode;

@end

