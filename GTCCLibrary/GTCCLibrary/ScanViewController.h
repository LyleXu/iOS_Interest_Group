//
//  ScanViewController.h
//  GTCCLibrary
//
//  Created by LyleXu on 1/9/13.
//  Copyright (c) 2013 __MyCompanyName__. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "ZBarReaderController.h"
@interface ScanViewController : UIViewController    
< ZBarReaderDelegate >
{
    UIImageView *resultImage;
    UITextView *resultText;
}
@property (nonatomic, retain) IBOutlet UIImageView *resultImage;

@property (nonatomic, retain) IBOutlet UITextView *resultText;

@property (weak, nonatomic) IBOutlet UILabel *bookTitle;
@property (weak, nonatomic) IBOutlet UILabel *bookAuthor;

@property (weak, nonatomic) IBOutlet UILabel *bookPublishedBy;
@property (weak, nonatomic) IBOutlet UILabel *bookPublishedYear;
@property (weak, nonatomic) IBOutlet UILabel *bookPage;
@property (weak, nonatomic) IBOutlet UILabel *bookPrice;
- (IBAction) scanButtonTapped;
@end
