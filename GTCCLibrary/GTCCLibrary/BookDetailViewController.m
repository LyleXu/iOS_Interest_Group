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
@synthesize bookInfo = _bookInfo;
@synthesize theImage;
@synthesize scrollView;
@synthesize descTextView;
@synthesize publisher;
@synthesize publishedDate;
@synthesize printLength;
@synthesize bookISBN;
@synthesize borrowButton;
@synthesize bookTitle;
@synthesize bookPrice;


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

-(void) CheckBorrowButton
{
   if([DataLayer checkWhetherBookInBorrow:self.bookInfo.bianhao])
   {
       self.navigationItem.rightBarButtonItem = nil;
   }else
   {
       self.navigationItem.rightBarButtonItem = [[UIBarButtonItem alloc] initWithTitle:@"Borrow" style:UIBarButtonItemStyleBordered target:self action:@selector(doBorrow)];
   }
}

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view.
    
        
    self.scrollView.contentSize = CGSizeMake(scrollView.frame.size.width, 600.0f);
    self.scrollView.scrollEnabled = YES;
    
    self.descTextView.layer.borderWidth = 5.0f;
    self.descTextView.layer.borderColor = [[UIColor grayColor] CGColor];
    self.descTextView.autoresizingMask = UIViewAutoresizingFlexibleHeight;
    
    self.descTextView.text = self.bookInfo.bookDescription;
    
    self.bookTitle.text = self.bookInfo.title;
    self.bookISBN.text = self.bookInfo.ISBN;
    self.authorName.text = self.bookInfo.author;
    self.publisher.text = self.bookInfo.publisher;
    self.printLength.text = [self.bookInfo.printLength stringValue];
    self.publishedDate.text = self.bookInfo.publishedDate;
    
    self.theImage.image = [Utility getImageFromUrl:self.bookInfo.ISBN];
    self.theImage.layer.borderColor = [[UIColor blackColor] CGColor];
    self.bookPrice.text = self.bookInfo.price;
    
    [self CheckBorrowButton];

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
    [self setPrintLength:nil];
    [self setBorrowButton:nil];
    [self setBookISBN:nil];
    [self setBorrowButton:nil];
    [self setBookTitle:nil];
    [self setBookPrice:nil];
    [super viewDidUnload];
    // Release any retained subviews of the main view.
}

- (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation
{
    return (interfaceOrientation == UIInterfaceOrientationPortrait);
}

- (void)doBorrow {
    NSString* username =  [Utility getUsername];
    NSString* bookBianhao = self.bookInfo.bianhao;
   if([DataLayer Borrow:username bookBianhao:bookBianhao])
   {
       // alert borrow sucessfully
       [Utility Alert:@"Borrow" message:@"Borrow Successfully!"];
       self.navigationItem.rightBarButtonItem = nil;
   }else
   {
       [Utility Alert:@"Borrow" message:@"Borrow Failed! It may be borrowed by others."];

   }
}

@end
