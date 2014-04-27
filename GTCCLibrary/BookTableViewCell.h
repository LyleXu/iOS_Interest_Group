//
//  BookTableViewCell.h
//  GTCC Library
//
//  Created by LyleXu on 4/27/14.
//
//

#import <UIKit/UIKit.h>

@interface BookTableViewCell : UITableViewCell

@property (nonatomic,weak) IBOutlet UILabel* lblTitle;
@property (nonatomic,weak) IBOutlet UIImageView* imageView;
@property (nonatomic,weak) IBOutlet UILabel* lblTag;
@end
