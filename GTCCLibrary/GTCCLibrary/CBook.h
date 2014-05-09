//
//  CBook.h
//  GTCCLibrary
//
//  Created by Lyle on 9/27/12.
//  Copyright (c) 2012 __MyCompanyName__. All rights reserved.
//

#import <Foundation/Foundation.h>

@interface CBook : NSObject{

}

@property(nonatomic,retain) NSString *title;
@property(nonatomic,retain) NSString *bianhao;
@property(nonatomic,retain) NSString *author;
@property(nonatomic,retain) NSString *publisher;
@property(nonatomic,retain) NSString *publishedDate;
@property(nonatomic,retain) NSString *language;
@property(nonatomic,retain) NSNumber *printLength;
@property(nonatomic,retain) NSString *ISBN;
@property(nonatomic,retain) NSString *price;
@property(nonatomic,retain) NSString *imageUrl;
@property(nonatomic,retain) NSString *bookDescription;
@property(nonatomic,retain) NSString *firstLetter;

-(void) Parse:(NSDictionary*) data;

@end
