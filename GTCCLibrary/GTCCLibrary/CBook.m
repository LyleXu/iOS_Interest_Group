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
    self.bianhao = [data objectForKey:@"bianhao"];
    self.title = [data objectForKey:@"title"] != [NSNull null] ? [data objectForKey:@"title"] : nil;
    self.author = [data objectForKey:@"author"] != [NSNull null] ? [data objectForKey:@"author"] : nil;
    self.publisher = [data objectForKey:@"publisher"] != [NSNull null] ? [data objectForKey:@"publisher"] : nil;
    self.publishedDate = [data objectForKey:@"publishedDate"] != [NSNull null] ? [data objectForKey:@"publishedDate"] : nil;
    self.language = [data objectForKey:@"language"] != [NSNull null] ? [data objectForKey:@"language"] : nil;
    self.printLength = [data objectForKey:@"printLength"] != [NSNull null] ? [data objectForKey:@"printLength"] : nil;
    self.ISBN = [data objectForKey:@"ISBN"] != [NSNull null] ? [data objectForKey:@"ISBN"] : nil;
    self.price = [data objectForKey:@"price"] != [NSNull null] ? [data objectForKey:@"price"] : nil;
    self.imageUrl = [data objectForKey:@"imageUrl"] != [NSNull null] ? [data objectForKey:@"imageUrl"] : nil;
    self.bookDescription = [data objectForKey:@"bookDescription"] != [NSNull null] ? [data objectForKey:@"bookDescription"] : nil;
}
@end
