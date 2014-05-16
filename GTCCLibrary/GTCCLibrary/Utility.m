//
//  Utility.m
//  GTCCLibrary
//
//  Created by Lyle on 10/20/12.
//
//

#import "Utility.h"
#import "pinyin.h"
#import "RegexKitLite.h"
@interface Utility ()

@end

@implementation Utility
static NSDictionary* category;
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

+(NSDictionary*) getBookCategory
{
    if(category == nil)
    {
        //category = [NSDictionary dictionaryWithObjectsAndKeys:@"Engineering", @"E", @"Foreign Languages", @"F", @"Management", @"M", @"Self-Improvement", @"S", @"Technical", @"T", @"Miscellaneous", @"Z",nil];
        
        category = [NSDictionary dictionaryWithObjectsAndKeys:@"#",@"#",@"A",@"A",@"B",@"B",@"C",@"C",@"D",@"D",@"E",@"E",@"F",@"F",@"G",@"G",@"H",@"H",@"I",@"I",@"J",@"J",@"K",@"K",@"L",@"L",@"M",@"M",@"N",@"N",@"O",@"O",@"P",@"P",@"Q",@"Q",@"R",@"R",@"S",@"S",@"T",@"T",@"U",@"U",@"V",@"V",@"W",@"W",@"X",@"X",@"Y",@"Y",@"Z",@"Z",nil];
    }
    return category;
}

+(NSString*) getFirstLetter:(NSString*) firstName
{
    NSString* firstLetter;
    
    //If the firstname is English already, return a-z or #
    //If the firstname is Chinese, return pinyin
    if ([firstName canBeConvertedToEncoding:NSASCIIStringEncoding])
    {
        if ([firstName isMatchedByRegex:@"^[A-Za-z]+$"]) {
             firstLetter = firstName;
        }
        else{
            firstLetter = @"#";
        }
    }
    else
    {
        firstLetter = [NSString stringWithFormat:@"%c", pinyinFirstLetter([firstName characterAtIndex:0])];
    }
    
    return [firstLetter uppercaseString];
}
@end
