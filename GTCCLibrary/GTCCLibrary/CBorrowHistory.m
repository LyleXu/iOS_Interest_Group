//
//  CBorrowHistory.m
//  GTCCLibrary
//
//  Created by Lyle on 10/21/12.
//
//

#import "CBorrowHistory.h"


@implementation CBorrowHistory
@synthesize username,bookName,bookBianhao, borrowDate,planReturnDate,realReturnDate,ISBN;

-(void) Parse:(NSDictionary*) data
{
    self.username = [data objectForKey:@"username"];
    self.bookName = [data objectForKey:@"bookName"];
    self.bookBianhao = [data objectForKey:@"bookBianhao"];
    self.borrowDate = [data objectForKey:@"borrowDate"];
    self.planReturnDate = [data objectForKey:@"planReturnDate"];
    self.realReturnDate = [data objectForKey:@"realReturnDate"];
    self.ISBN = [data objectForKey:@"ISBN"];
}
@end
