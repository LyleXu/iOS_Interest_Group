//
//  CBorrowHistory.h
//  GTCCLibrary
//
//  Created by Lyle on 10/21/12.
//
//

#import <Foundation/Foundation.h>

@interface CBorrowHistory : NSObject
@property(nonatomic,retain) NSString *username;
@property(nonatomic,retain) NSString *bookName;
@property(nonatomic,retain) NSString *bookBianhao;
@property(nonatomic,retain) NSString *borrowDate;
@property(nonatomic,retain) NSString *planReturnDate;
@property(nonatomic,retain) NSString *realReturnDate;

-(void) Parse:(NSDictionary*) data;
@end
