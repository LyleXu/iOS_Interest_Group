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
#import "DataLayer.h"

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
@synthesize borrowButton;


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

-(void) setButtonDisabled
{
    self.borrowButton.enabled = false;
    [self.borrowButton setTitleColor:[UIColor grayColor] forState:UIControlStateDisabled];
}

-(void) CheckBorrowButton
{
   if([DataLayer checkWhetherBookInBorrow:self.bookInfo.bianhao])
   {
       [self setButtonDisabled];
   }else
   {
       self.borrowButton.enabled = true;
       [self.borrowButton setTitleColor:[UIColor blueColor] forState:UIControlStateNormal];
   }
}

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view.
    
    self.authorName.text = self.bookInfo.author;
    self.publisher.text = self.bookInfo.publisher;
    self.language.text = self.bookInfo.language;
    self.printLength.text = [self.bookInfo.printLength stringValue];
    self.publishedDate.text = self.bookInfo.publishedDate;
    
    self.theImage.image = [Utility getImageFromUrl:self.bookInfo.title];
    self.theImage.layer.borderColor = [[UIColor blackColor] CGColor];

    
    self.infoView.backgroundColor = [UIColor whiteColor];
    self.infoView.layer.borderWidth = 1;
    self.infoView.layer.borderColor = [[UIColor blackColor] CGColor];
    
    
    [self CheckBorrowButton];
    
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
    [self setBorrowButton:nil];
    [super viewDidUnload];
    // Release any retained subviews of the main view.
}

- (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation
{
    return (interfaceOrientation == UIInterfaceOrientationPortrait);
}

- (IBAction)doBorrow:(id)sender {
    NSString* username =  [Utility getUsername];
    NSString* bookBianhao = self.bookInfo.bianhao;
   if([DataLayer Borrow:username bookBianhao:bookBianhao])
   {
       // alert borrow sucessfully
       [Utility Alert:@"Borrow" message:@"Borrow Successfully!"];
       [self setButtonDisabled];
   }else
   {
       [Utility Alert:@"Borrow" message:@"Borrow Failed! It may be borrowed by others."];

   }
}

@end
