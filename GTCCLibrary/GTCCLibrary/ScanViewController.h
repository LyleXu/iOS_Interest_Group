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


- (IBAction) scanButtonTapped;
@end
