//
//  Utility.h
//  GTCCLibrary
//
//  Created by Lyle on 10/20/12.
//
//

#import <Foundation/Foundation.h>
#import "Constraint.h"
@interface Utility : NSObject
+(UIImage*) getImageFromUrl:(NSString*) imageName;
+(void) Alert:(NSString*) title
      message: (NSString*) msg;

+(NSString*) getUsername;

+(NSString*) getGUID;
+(NSString*) replaceQuote:(NSString*) source;
+(NSString*) replaceStringWithBlank:(NSString*) source;
@end
