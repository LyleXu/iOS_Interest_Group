//
//  ScanViewController.m
//  GTCCLibrary
//
//  Created by LyleXu on 1/9/13.
//  Copyright (c) 2013 __MyCompanyName__. All rights reserved.
//

#import "ScanViewController.h"
#import "ZBarReaderViewController.h"
#import "RegexKitLite.h"
#import "DataLayer.h"
#import "Constraint.h"
#import <QuartzCore/QuartzCore.h>

@interface ScanViewController ()

@end

@implementation ScanViewController
@synthesize scrollView;
@synthesize bookImage;
@synthesize bookDesc;
@synthesize bookTitle;
@synthesize bookAuthor;
@synthesize bookPublishedBy;
@synthesize bookPublishedYear;
@synthesize bookPage;
@synthesize bookPrice;
@synthesize resultImage, resultText;
@synthesize tmpDesc;

- (IBAction) scanButtonTapped
{
    // ADD: present a barcode reader that scans from the camera feed
    ZBarReaderViewController *reader = [ZBarReaderViewController new];
    reader.readerDelegate = self;
    reader.supportedOrientationsMask = ZBarOrientationMaskAll;
    
    ZBarImageScanner *scanner = reader.scanner;
    // TODO: (optional) additional reader configuration here
    
    // EXAMPLE: disable rarely used I2/5 to improve performance
    [scanner setSymbology: ZBAR_I25
                   config: ZBAR_CFG_ENABLE
                       to: 0];
    
    // present and release the controller
    [self presentModalViewController: reader
                            animated: YES];

   
}

- (void)loadBookInfoFromWeb
{
    // Search the barcode on the network
    NSString* url = [[NSString alloc] initWithFormat:@"%@%@/",DouBanAPI,resultText.text];
    NSMutableString* response = [DataLayer FetchDataFromWeb:url];
    
    NSString *bookTitleRegexString = @"<span property=\"v:itemreviewed\">(.*)</span>";
    NSString *authorReg = @"作者</span>: \\s+<a href.+>(.*)</a>";
    NSString *publishedByReg = @"出版社:</span>\\s+(.*)<br/>";
    NSString *publishedYearReg = @"出版年:</span>(.*)<br/>";
    NSString *pageReg = @"页数:</span>(.*)<br/>";
    NSString *priceReg = @"定价:</span>(.*)<br/>";
    NSString *bookDescriptionReg = @"<div class=\"intro\">\n(.*)</div>";
    NSString *bookPicReg = @"img src=\"(.*)\" title=";
    
    bookTitle.text = [response stringByMatching:bookTitleRegexString capture:1L];
    bookAuthor.text = [response stringByMatching:authorReg capture:1L];
    bookPublishedBy.text = [response stringByMatching:publishedByReg capture:1L];
    bookPublishedYear.text = [response stringByMatching:publishedYearReg capture:1L];
    bookPage.text = [response stringByMatching:pageReg capture:1L];
    bookPrice.text = [response stringByMatching:priceReg capture:1L];
  
    // image
    NSString *picUrl = [response stringByMatching:bookPicReg capture:1L];
    UIImage *image = [[UIImage alloc] initWithData:[NSData dataWithContentsOfURL:[NSURL URLWithString:picUrl]]];
    bookImage.image = image;
    
    // description
    tmpDesc = [[response stringByMatching:bookDescriptionReg capture:1L] copy];
    tmpDesc = [tmpDesc stringByReplacingOccurrencesOfRegex:@"<p>" withString:@""];
    tmpDesc = [tmpDesc stringByReplacingOccurrencesOfRegex:@"</p>" withString:@"\n"];
    // update the UI on the main thread. but not know why I can update label and image on the thread
    [self performSelectorOnMainThread:@selector(updateDescription) withObject:nil waitUntilDone:false];
}

-(void)updateDescription
{
    self.bookDesc.text = tmpDesc;
    
    self.scrollView.hidden = false;
}

- (void) imagePickerController: (UIImagePickerController*) reader
 didFinishPickingMediaWithInfo: (NSDictionary*) info
{
    // ADD: get the decode results
    id<NSFastEnumeration> results =
    [info objectForKey: ZBarReaderControllerResults];
    ZBarSymbol *symbol = nil;
    for(symbol in results)
        // EXAMPLE: just grab the first barcode
        break;
    
    // EXAMPLE: do something useful with the barcode data
    resultText.text = symbol.data;
    
    // EXAMPLE: do something useful with the barcode image
    //resultImage.image =
    //[info objectForKey: UIImagePickerControllerOriginalImage];
    
    // ADD: dismiss the controller (NB dismiss from the *reader*!)
    [reader dismissModalViewControllerAnimated: YES];
    
    HUD = [[MBProgressHUD alloc] initWithView:self.navigationController.view];
	[self.navigationController.view addSubview:HUD];
	
	HUD.delegate = self;
	HUD.labelText = @"Loading";
	HUD.detailsLabelText = @"Getting Book Info";
	HUD.square = YES;
	
	[HUD showWhileExecuting:@selector(loadBookInfoFromWeb) onTarget:self withObject:nil animated:YES];
}

-(void)addBookToServer
{
    
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
    self.scrollView.contentSize = CGSizeMake(scrollView.frame.size.width, 600.0f);
    self.scrollView.scrollEnabled = YES;
    
    self.scrollView.hidden = true;
    
    self.bookDesc.layer.borderWidth = 5.0f;
    self.bookDesc.layer.borderColor = [[UIColor grayColor] CGColor];
    self.bookDesc.autoresizingMask = UIViewAutoresizingFlexibleHeight;
    
    [self scanButtonTapped];
}

- (void)viewDidUnload
{
    [self setBookTitle:nil];
    [self setBookAuthor:nil];
    [self setBookPublishedBy:nil];
    [self setBookPublishedYear:nil];
    [self setBookPage:nil];
    [self setBookPrice:nil];
    [self setScrollView:nil];
    [self setBookImage:nil];
    [self setBookDesc:nil];
    [super viewDidUnload];
    // Release any retained subviews of the main view.
}

- (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation
{
    return (interfaceOrientation == UIInterfaceOrientationPortrait);
}

@end
