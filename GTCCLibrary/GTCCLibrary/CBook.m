//
//  CBook.m
//  GTCCLibrary
//
//  Created by Lyle on 9/27/12.
//  Copyright (c) 2012 __MyCompanyName__. All rights reserved.
//

#import "CBook.h"

@implementation CBook
@synthesize title,bianhao;


-(void) Parse:(NSDictionary*) data
{
    self.title = [data objectForKey:@"title"];
    self.bianhao = [data objectForKey:@"bianhao"];
}
@end
