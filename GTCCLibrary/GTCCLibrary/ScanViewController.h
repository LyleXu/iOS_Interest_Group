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


@property (weak, nonatomic) IBOutlet UITextField *resultISBN;

@property (weak, nonatomic) IBOutlet UILabel *bookTitle;
@property (weak, nonatomic) IBOutlet UITextField *bookAuthor;
@property (weak, nonatomic) IBOutlet UITextField *bookPublishedBy;
@property (weak, nonatomic) IBOutlet UITextField *bookPublishedYear;
@property (weak, nonatomic) IBOutlet UITextField *bookPage;
@property (weak, nonatomic) IBOutlet UITextField *bookPrice;
@property (weak, nonatomic) IBOutlet UIImageView *bookImage;
@property (retain, nonatomic) IBOutlet UITextView *bookDesc;

@property (weak, nonatomic) IBOutlet UIScrollView *scrollView;
@property (retain, nonatomic) NSString* tmpDesc;
@property (retain, nonatomic) NSString* picUrl;

- (void) loadBookInfoFromWeb;
- (void) updateDescription;
- (IBAction)addBookToServer;
@end
