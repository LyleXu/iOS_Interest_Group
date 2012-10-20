//
//  CBook.h
//  GTCCLibrary
//
//  Created by Lyle on 9/27/12.
//  Copyright (c) 2012 __MyCompanyName__. All rights reserved.
//

#import <Foundation/Foundation.h>

@interface CBook : NSObject{
    NSString *title;
    NSString *bianhao;
    NSString *author;
}

@property(nonatomic,retain) NSString *title;
@property(nonatomic,retain) NSString *bianhao;
@property(nonatomic,retain) NSString *author;
@property(nonatomic,retain) NSString *publisher;
@property(nonatomic,retain) NSNumber *publishedDate;
@property(nonatomic,retain) NSString *language;
@property(nonatomic,retain) NSNumber *printLength;

-(void) Parse:(NSDictionary*) data;

@end
