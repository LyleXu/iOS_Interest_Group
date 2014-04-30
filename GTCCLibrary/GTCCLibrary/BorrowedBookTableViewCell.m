//
//  BorrowedBookTableViewCell.m
//  GTCC Library
//
//  Created by gtcc on 4/30/14.
//
//

#import "BorrowedBookTableViewCell.h"

@implementation BorrowedBookTableViewCell
@synthesize lblTitle, dueDate,borrowedDate,imageView;
- (id)initWithStyle:(UITableViewCellStyle)style reuseIdentifier:(NSString *)reuseIdentifier
{
    self = [super initWithStyle:style reuseIdentifier:reuseIdentifier];
    if (self) {
        // Initialization code
    }
    return self;
}

- (void)awakeFromNib
{
    // Initialization code
}

- (void)setSelected:(BOOL)selected animated:(BOOL)animated
{
    [super setSelected:selected animated:animated];

    // Configure the view for the selected state
}

@end
