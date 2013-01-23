//
//  CBook.m
//  GTCCLibrary
//
//  Created by Lyle on 9/27/12.
//  Copyright (c) 2012 __MyCompanyName__. All rights reserved.
//

#import "CBook.h"

@implementation CBook
@synthesize title,bianhao,author,publisher,publishedDate,language,printLength,ISBN,price,bookDescription,imageUrl;


-(void) Parse:(NSDictionary*) data
{
    self.title = [data objectForKey:@"title"];
    self.bianhao = [data objectForKey:@"bianhao"];
    self.author = [data objectForKey:@"author"];
    self.publisher = [data objectForKey:@"publisher"];
    self.publishedDate = [data objectForKey:@"publishedDate"];
    self.language = [data objectForKey:@"language"];
    self.printLength = [data objectForKey:@"printLength"];
    self.ISBN = [data objectForKey:@"ISBN"];
    self.price = [data objectForKey:@"price"];
    self.imageUrl = [data objectForKey:@"imageUrl"];
    self.bookDescription = [data objectForKey:@"description"];
}
@end
