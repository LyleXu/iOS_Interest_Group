//
//  Utility.m
//  GTCCLibrary
//
//  Created by Lyle on 10/20/12.
//
//

#import "Utility.h"

#define ServerImagePath @"http://localhost/~Lyle/gtcclibrary/Images/"

@implementation Utility

+(NSString*) replaceWhiteSpace:(NSString*) url
{
    url = [url stringByReplacingOccurrencesOfString:@" " withString:@"%20"];
    return [url stringByReplacingOccurrencesOfString:@"#" withString:@"%23"];
}

+(UIImage*) getImageFromUrl:(NSString*) imageName
{
    NSString* imageUrl = ServerImagePath;
    imageUrl = [self replaceWhiteSpace:[imageUrl stringByAppendingFormat: @"%@.jpg", imageName]];
    
    NSData * data = [NSData dataWithContentsOfURL:[NSURL URLWithString:imageUrl]];
    return [UIImage imageWithData:data];
}

@end
