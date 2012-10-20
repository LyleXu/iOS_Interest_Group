//
//  BookDetailViewController.m
//  GTCCLibrary
//
//  Created by Lyle on 10/17/12.
//
//

#import "BookDetailViewController.h"
#import "Utility.h"
#import <QuartzCore/QuartzCore.h>
@interface BookDetailViewController ()

@end

@implementation BookDetailViewController

@synthesize authorName;
@synthesize infoView;
@synthesize bookInfo = _bookInfo;
@synthesize theImage;
@synthesize scrollView;
@synthesize descTextView;
@synthesize publisher;
@synthesize publishedDate;
@synthesize language;
@synthesize printLength;


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
    self.publisher.text = self.bookInfo.publisher;
    self.language.text = self.bookInfo.language;
    self.printLength.text = [self.bookInfo.printLength stringValue];
    self.publishedDate.text = [self.bookInfo.publishedDate stringValue];
    
    self.theImage.image = [Utility getImageFromUrl:self.bookInfo.title];
    self.theImage.layer.borderColor = [[UIColor blackColor] CGColor];

    
    self.infoView.backgroundColor = [UIColor whiteColor];
    self.infoView.layer.borderWidth = 1;
    self.infoView.layer.borderColor = [[UIColor blackColor] CGColor];
    
    self.scrollView.contentSize = CGSizeMake(scrollView.frame.size.width, 1400.0f);
    scrollView.scrollEnabled = YES;
    scrollView.backgroundColor = [UIColor grayColor];
}

- (void)viewDidUnload
{
    [self setAuthorName:nil];
    [self setTheImage:nil];
    [self setScrollView:nil];
    [self setScrollView:nil];
    [self setDescTextView:nil];
    [self setPublisher:nil];
    [self setPublishedDate:nil];
    [self setLanguage:nil];
    [self setPrintLength:nil];
    [self setInfoView:nil];
    [super viewDidUnload];
    // Release any retained subviews of the main view.
}

- (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation
{
    return (interfaceOrientation == UIInterfaceOrientationPortrait);
}

@end
