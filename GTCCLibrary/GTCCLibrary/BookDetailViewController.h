//
//  BookDetailViewController.h
//  GTCCLibrary
//
//  Created by Lyle on 10/17/12.
//
//

#import <UIKit/UIKit.h>
#import "CBook.h"
@interface BookDetailViewController : UIViewController
@property (weak, nonatomic) IBOutlet UIView *infoView;

@property (weak,nonatomic) CBook* bookInfo;

@property (weak, nonatomic) IBOutlet UILabel *authorName;
@property (weak, nonatomic) IBOutlet UIImageView *theImage;
@property (weak, nonatomic) IBOutlet UIScrollView *scrollView;
@property (weak, nonatomic) IBOutlet UITextView *descTextView;
@property (weak, nonatomic) IBOutlet UILabel *publisher;
@property (weak, nonatomic) IBOutlet UILabel *publishedDate;
@property (weak, nonatomic) IBOutlet UILabel *language;
@property (weak, nonatomic) IBOutlet UILabel *printLength;
@end
