//
//  BorrowedBookTableViewCell.h
//  GTCC Library
//
//  Created by gtcc on 4/30/14.
//
//

#import <UIKit/UIKit.h>

@interface BorrowedBookTableViewCell : UITableViewCell

@property (nonatomic,weak) IBOutlet UILabel* lblTitle;
@property (nonatomic,weak) IBOutlet UILabel* lblTag;
@property (nonatomic,weak) IBOutlet UIImageView* imageView;
@property (nonatomic,weak) IBOutlet UILabel* borrowedDate;
@property (nonatomic,weak) IBOutlet UILabel* dueDate;

@end
