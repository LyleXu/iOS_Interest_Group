//
//  BookDetailViewController.m
//  GTCCLibrary
//
//  Created by Lyle on 10/17/12.
//
//

#import "BookDetailViewController.h"

@interface BookDetailViewController ()

@end

@implementation BookDetailViewController
@synthesize authorName;
@synthesize bookInfo = _bookInfo;

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
}

- (void)viewDidUnload
{
    [self setAuthorName:nil];
    [super viewDidUnload];
    // Release any retained subviews of the main view.
}

- (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation
{
    return (interfaceOrientation == UIInterfaceOrientationPortrait);
}

@end
