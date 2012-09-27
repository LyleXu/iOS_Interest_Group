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
}

@property(nonatomic,retain) NSString *title;
@property(nonatomic,retain) NSString *bianhao;

-(void) Parse:(NSDictionary*) data;

@end
