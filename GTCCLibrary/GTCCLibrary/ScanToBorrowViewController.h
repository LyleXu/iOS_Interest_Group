//
//  ScanToBorrowViewController.h
//  GTCC Library
//
//  Created by gtcc on 4/29/14.
//
//

#import <UIKit/UIKit.h>
#import "ZBarReaderController.h"
#import "MBProgressHUD.h"
@interface ScanToBorrowViewController : UIViewController
< ZBarReaderDelegate,MBProgressHUDDelegate, UIPickerViewDataSource,UIPickerViewDelegate >
{
        MBProgressHUD *HUD;
}

@property (weak, nonatomic) IBOutlet UILabel *bookTitle;
@property (weak, nonatomic) IBOutlet UILabel *bookAuthor;
@property (weak, nonatomic) IBOutlet UILabel *bookPublishedBy;
@property (weak, nonatomic) IBOutlet UILabel *bookPublishedYear;
@property (weak, nonatomic) IBOutlet UILabel *bookISBN;
@property (weak, nonatomic) IBOutlet UILabel *bookPage;
@property (weak, nonatomic) IBOutlet UILabel *bookPrice;
@property (weak, nonatomic) IBOutlet UIImageView *bookImage;
@property (retain, nonatomic) IBOutlet UITextView *bookDesc;

@property (weak, nonatomic) IBOutlet UIScrollView *scrollView;
@property (weak, nonatomic) IBOutlet UIBarButtonItem *borrowButton;
@property (weak, nonatomic) IBOutlet UITextField   *txtTag;
@property (weak, nonatomic) IBOutlet UIPickerView *tagPickerView;
-(void)loadBookInfo;


@end
