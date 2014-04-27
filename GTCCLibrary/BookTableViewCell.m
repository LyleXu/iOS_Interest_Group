//
//  BookTableViewCell.m
//  GTCC Library
//
//  Created by LyleXu on 4/27/14.
//
//

#import "BookTableViewCell.h"

@implementation BookTableViewCell
@synthesize lblTag,lblTitle,imageView;
- (id)initWithStyle:(UITableViewCellStyle)style reuseIdentifier:(NSString *)reuseIdentifier
{
    self = [super initWithStyle:style reuseIdentifier:reuseIdentifier];
    if (self) {
        // Initialization code
        //添加边框
        CALayer * layer = [imageView layer];
        layer.borderColor = [
                             [UIColor whiteColor] CGColor];
        layer.borderWidth = 5.0f;
        //添加四个边阴影
        imageView.layer.shadowColor = [UIColor blackColor].CGColor;
        imageView.layer.shadowOffset = CGSizeMake(0, 0);
        imageView.layer.shadowOpacity = 0.5;
        imageView.layer.shadowRadius = 10.0;
//        //添加两个边阴影
//        imageView.layer.shadowColor = [UIColor blackColor].CGColor;
//        imageView.layer.shadowOffset = CGSizeMake(4, 4);
//        imageView.layer.shadowOpacity = 0.5;  
//        imageView.layer.shadowRadius = 2.0;
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
