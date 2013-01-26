//
//  MyLiraryViewController.m
//  GTCCLibrary
//
//  Created by Lyle on 10/21/12.
//
//

#import "MyLiraryViewController.h"
#import "Utility.h"
#import "DataLayer.h"
@interface MyLiraryViewController ()

@end

@implementation MyLiraryViewController
@synthesize infoView;
@synthesize bookTitle;
@synthesize borrowDate;
@synthesize planReturnDate;
@synthesize imageView;
@synthesize borrowHistory = _borrowHistory;
//@synthesize returnButton;
@synthesize borrowDateLabel;
@synthesize planReturnDateLabel;
@synthesize smileImage;
@synthesize noBookLabel;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

-(void) hiddenSubViews:(BOOL) visible
{
    if(visible)
    {
        self.navigationItem.rightBarButtonItem = nil;
    }else {
        self.navigationItem.rightBarButtonItem = [[UIBarButtonItem alloc] initWithTitle:@"Return" style:UIBarButtonItemStyleBordered target:self action:@selector(doReturnBook)];
    }
   
    infoView.hidden = visible;
    
    smileImage.hidden = !visible;
    noBookLabel.hidden = !visible;
}

-(void) refresh
{
    NSString* username = [Utility getUsername];
    CBorrowHistory* history = [DataLayer getBorrowInfo:username];
    if(history)
    {
        [self hiddenSubViews:false];
        
        self.borrowHistory = history;
        bookTitle.text = history.bookName;
        imageView.image = [Utility getImageFromUrl:history.ISBN];
        borrowDate.text = history.borrowDate;
        planReturnDate.text = history.planReturnDate;
    }else
    {
        
        [self hiddenSubViews:true];
    }

}

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view.
    
}

-(void) viewWillAppear:(BOOL)animated
{
    [self refresh];
}

- (void)viewDidUnload
{
    [self setInfoView:nil];
    [self setBookTitle:nil];
    [self setBorrowDate:nil];
    [self setPlanReturnDate:nil];
    [self setImageView:nil];
    [self setBorrowDateLabel:nil];
    [self setPlanReturnDateLabel:nil];
    //[self setReturnButton:nil];
    [self setSmileImage:nil];
    [self setNoBookLabel:nil];
    [super viewDidUnload];
    // Release any retained subviews of the main view.
}

- (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation
{
    return (interfaceOrientation == UIInterfaceOrientationPortrait);
}
- (void)doReturnBook
{
    NSString* username = [Utility getUsername];
    NSString* bookBianhao = [self.borrowHistory bookBianhao];
    if([DataLayer ReturnBook:username bookBianhao:bookBianhao])
    {
        [Utility Alert:@"Return" message:@"Return Book Successfully!"];
        [self refresh];
    }else
    {
        [Utility Alert:@"Return" message:@"Return Book Failed!"];
    }
}

@end
