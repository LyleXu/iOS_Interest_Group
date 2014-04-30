//
//  MyLiraryViewController.h
//  GTCCLibrary
//
//  Created by Lyle on 10/21/12.
//
//

#import <UIKit/UIKit.h>
#import "CBorrowHistory.h"
@interface MyLiraryViewController : UIViewController <UIActionSheetDelegate, UITableViewDataSource, UITableViewDelegate>

@property (weak, nonatomic) NSMutableArray* borrowedBooks;
@property (weak, nonatomic) IBOutlet UITableView *myBookTableView;
@end
