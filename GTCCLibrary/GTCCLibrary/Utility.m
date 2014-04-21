//
//  Utility.m
//  GTCCLibrary
//
//  Created by Lyle on 10/20/12.
//
//

#import "Utility.h"



@implementation Utility

+(NSString*) replaceWhiteSpace:(NSString*) url
{
    url = [url stringByReplacingOccurrencesOfString:@" " withString:@"%20"];
    return [url stringByReplacingOccurrencesOfString:@"#" withString:@"%23"];
}

+(NSString*) replaceQuote:(NSString*) source
{
    return [source stringByReplacingOccurrencesOfString:@"&#39;" withString:@"'"];
}

+(NSString*) replaceStringWithBlank:(NSString*) source
{
    return [source stringByReplacingOccurrencesOfString:@"在线阅读本书" withString:@""];
}

+(UIImage*) getImageFromUrl:(NSString*) imageName
{
    NSString* imageUrl = [[NSString alloc] initWithFormat:@"%@%@",ServerHost,ServerImagePath];
    imageUrl = [self replaceWhiteSpace:[imageUrl stringByAppendingFormat: @"%@.jpg", imageName]];
    
    NSData * data = [NSData dataWithContentsOfURL:[NSURL URLWithString:imageUrl]];
    return [UIImage imageWithData:data];
}

+(void) Alert:(NSString *)title message:(NSString *)msg
{
    UIAlertView *alert1 = [[UIAlertView alloc] initWithTitle:title message:msg delegate:nil cancelButtonTitle:@"OK" otherButtonTitles:nil];
    [alert1 show];
}

+(NSString*) getUsername
{
    NSUserDefaults *mydefault = [NSUserDefaults standardUserDefaults];
    return  [mydefault objectForKey:USERNAME];
}

+(void)clearUserInfo
{
    NSUserDefaults *mydefault = [NSUserDefaults standardUserDefaults];
    [mydefault setObject:@"" forKey:USERNAME];
    [mydefault synchronize];
}

+(NSString *)getGUID
{
    CFUUIDRef uuidObj = CFUUIDCreate(nil);
    CFStringRef newGUID = CFUUIDCreateString(nil, uuidObj);
    CFRelease(uuidObj);
    return (__bridge NSString*)newGUID ;
    
}

@end
