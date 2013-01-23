//
//  ScanViewController.h
//  GTCCLibrary
//
//  Created by LyleXu on 1/9/13.
//  Copyright (c) 2013 __MyCompanyName__. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "ZBarReaderController.h"
#import "MBProgressHUD.h"
@interface ScanViewController : UIViewController    
< ZBarReaderDelegate,MBProgressHUDDelegate >
{
    UIImageView *resultImage;
    UILabel *resultText;
    UITextView * bookDesc;
    MBProgressHUD *HUD;
}
@property (nonatomic, retain) IBOutlet UIImageView *resultImage;

@property (nonatomic, retain) IBOutlet UILabel *resultText;

@property (weak, nonatomic) IBOutlet UILabel *bookTitle;
@property (weak, nonatomic) IBOutlet UILabel *bookAuthor;
@property (weak, nonatomic) IBOutlet UILabel *bookPublishedBy;
@property (weak, nonatomic) IBOutlet UILabel *bookPublishedYear;
@property (weak, nonatomic) IBOutlet UILabel *bookPage;
@property (weak, nonatomic) IBOutlet UILabel *bookPrice;
@property (weak, nonatomic) IBOutlet UIImageView *bookImage;
@property (retain, nonatomic) IBOutlet UITextView *bookDesc;

@property (weak, nonatomic) IBOutlet UIScrollView *scrollView;
@property (retain, nonatomic) NSString* tmpDesc;
@property (retain, nonatomic) NSString* picUrl;

- (IBAction) scanButtonTapped;
- (void) loadBookInfoFromWeb;
- (void) updateDescription;
- (IBAction)addBookToServer;
@end
