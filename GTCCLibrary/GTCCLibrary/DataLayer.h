//
//  DataLayer.h
//  GTCCLibrary
//
//  Created by Lyle on 7/26/12.
//  Copyright (c) 2012 __MyCompanyName__. All rights reserved.
//

#import <Foundation/Foundation.h>

@interface DataLayer : NSObject

+(BOOL) Login:(NSString*)userName
password:(NSString*)password;
@end
