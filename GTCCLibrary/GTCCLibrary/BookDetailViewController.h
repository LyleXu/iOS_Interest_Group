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
@property (weak, nonatomic) IBOutlet UILabel *authorName;
@property (weak,nonatomic) CBook* bookInfo;
@end
