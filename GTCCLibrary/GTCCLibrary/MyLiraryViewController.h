//
//  MyLiraryViewController.h
//  GTCCLibrary
//
//  Created by Lyle on 10/21/12.
//
//

#import <UIKit/UIKit.h>
#import "CBorrowHistory.h"
@interface MyLiraryViewController : UIViewController <UIActionSheetDelegate>

@property (weak, nonatomic) IBOutlet UIView *infoView;
@property (weak, nonatomic) IBOutlet UILabel *bookTitle;
@property (weak, nonatomic) IBOutlet UILabel *borrowDate;

@property (weak, nonatomic) IBOutlet UILabel *planReturnDate;
@property (weak, nonatomic) IBOutlet UIImageView *imageView;

@property (retain, nonatomic) CBorrowHistory* borrowHistory;
//@property (weak, nonatomic) IBOutlet UIBarButtonItem *returnButton;

@property (weak, nonatomic) IBOutlet UILabel *borrowDateLabel;
@property (weak, nonatomic) IBOutlet UILabel *planReturnDateLabel;
@property (weak, nonatomic) IBOutlet UIImageView *smileImage;
@property (weak, nonatomic) IBOutlet UILabel *noBookLabel;

@end
