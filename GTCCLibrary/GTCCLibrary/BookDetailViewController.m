//
//  BookDetailViewController.m
//  GTCCLibrary
//
//  Created by Lyle on 10/17/12.
//
//

#import "BookDetailViewController.h"
#import "Utility.h"
@interface BookDetailViewController ()

@end

@implementation BookDetailViewController

@synthesize authorName;
@synthesize bookInfo = _bookInfo;
@synthesize theImage;
@synthesize scrollView;
@synthesize descTextView;


-(void)setBookInfo:(CBook *)bookInfo
{
    _bookInfo = bookInfo;
}

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view.
    
    self.authorName.text = self.bookInfo.author;
    self.descTextView.text = self.bookInfo.description;
    
    self.theImage.image = [Utility getImageFromUrl:self.bookInfo.title];
    
    self.scrollView.contentSize = CGSizeMake(scrollView.frame.size.width, 1400.0f);
    scrollView.scrollEnabled = YES;
    
    
}

- (void)viewDidUnload
{
    [self setAuthorName:nil];
    [self setTheImage:nil];
    [self setScrollView:nil];
    [self setScrollView:nil];
    [self setDescTextView:nil];
    [super viewDidUnload];
    // Release any retained subviews of the main view.
}

- (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation
{
    return (interfaceOrientation == UIInterfaceOrientationPortrait);
}

@end
