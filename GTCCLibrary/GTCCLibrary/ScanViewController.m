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
#import "Utility.h"
#import "SBJson.h"
#import "NSData+Base64.h"
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
@synthesize resultImage;
@synthesize resultISBN;
@synthesize tmpDesc;
@synthesize picUrl;


UIImagePickerController *picker;
UITextField *bookTagTextfield;
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
    
    
    @try {
        // present and release the controller
        [self presentModalViewController: reader
                                animated: YES];
    }
    @catch (NSException *exception) {
        [tmpDesc stringByAppendingString:exception.reason];
    }
}

- (void)loadBookInfoFromWeb
{
    @try {
    
        // Search the barcode on the network
        NSString* url = [[NSString alloc] initWithFormat:@"%@%@",DouBanAPI,resultISBN.text];
        NSMutableString* response = [DataLayer FetchDataFromWebByGet:url];
      
        SBJsonParser *jsonParser = [[SBJsonParser alloc] init];
        NSError *error = nil;
        NSDictionary* jsonObject = [jsonParser objectWithString:response error:&error];
        jsonParser = nil;
        bookTitle.text = [jsonObject objectForKey:@"title"];
        NSArray* authors = [jsonObject objectForKey:@"author"];
        if (authors.count > 0) {
            bookAuthor.text = (NSString*)[authors objectAtIndex:0];
        }
        else
        {
            bookAuthor.text = @"";
        }
        
        bookPublishedBy.text = [jsonObject objectForKey:@"publisher"];
        bookPublishedYear.text = [jsonObject objectForKey:@"pubdate"];
        bookPage.text = [jsonObject objectForKey:@"pages"];
        bookPrice.text = [jsonObject objectForKey:@"price"]; 
        
        // image
        picUrl = [jsonObject objectForKey:@"image"];
        UIImage *image = [[UIImage alloc] initWithData:[NSData dataWithContentsOfURL:[NSURL URLWithString:picUrl]]];
        bookImage.image = image;
        
        // description
        tmpDesc = [jsonObject objectForKey:@"summary"];
        
        tmpDesc = [Utility replaceStringWithBlank:tmpDesc];
    
    }
    @catch (NSException *exception) {
        [tmpDesc stringByAppendingString:exception.reason];
    }
        
    // update the UI on the main thread. but not know why I can update label and image on the thread
    [self performSelectorOnMainThread:@selector(updateDescription) withObject:nil waitUntilDone:false];
}

-(void) handleTouchBookImage: (UIGestureRecognizer*) gesture
{
    if(picker == nil)
        picker = [[UIImagePickerController alloc] init];

    picker.delegate = self;
    picker.allowsEditing = NO;
    picker.sourceType = UIImagePickerControllerSourceTypeCamera;
    [self presentModalViewController:picker animated:YES];
}

-(void)updateDescription
{
    self.bookDesc.text = tmpDesc;
    self.scrollView.hidden = false;
}

- (void)  imagePickerController: (UIImagePickerController*) reader
 didFinishPickingMediaWithInfo: (NSDictionary*) info
{
    if ([reader isKindOfClass: [UIImagePickerController class]])
    {
        [reader dismissModalViewControllerAnimated:YES];
        self.scrollView.hidden = false;
        UIImage *image = [info valueForKey:@"UIImagePickerControllerOriginalImage"];
        self.bookImage.image = image;
    }
    else
    {
        // ADD: get the decode results
        id<NSFastEnumeration> results =
        [info objectForKey: ZBarReaderControllerResults];
        ZBarSymbol *symbol = nil;
        for(symbol in results)
            // EXAMPLE: just grab the first barcode
            break;
        
        // EXAMPLE: do something useful with the barcode data
        resultISBN.text = symbol.data;
        
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
}

-(void)addBookToServer
{
    UIAlertView *alert = [[UIAlertView alloc] initWithTitle:@"Please enter the book tag" message:@"" delegate:self cancelButtonTitle:@"Cancel" otherButtonTitles:@"OK",nil];
    alert.alertViewStyle = UIAlertViewStylePlainTextInput;
    [alert show];
    
}

- (UIImage*)imageWithImage:(UIImage*)image
              scaledToSize:(CGSize)newSize;
{
    UIGraphicsBeginImageContext( newSize );
    [image drawInRect:CGRectMake(0,0,newSize.width,newSize.height)];
    UIImage* newImage = UIGraphicsGetImageFromCurrentImageContext();
    UIGraphicsEndImageContext();
    
    return newImage;
}

-(void)alertView:(UIAlertView *)alertView clickedButtonAtIndex:(NSInteger)buttonIndex{
    
    if(buttonIndex == 0)
    {
        return; // click cancel
    }
    
    NSString* bookTag = [alertView textFieldAtIndex:0].text;
    if([bookTag isEqualToString:@""])
    {
        [Utility Alert:@"" message:@"Book tag cannot be empty"];
        return;
    }    
    
    CBook* bookInfo = [[CBook alloc] init];
    bookInfo.bianhao = bookTag;
    bookInfo.title = bookTitle.text;
    bookInfo.author = bookAuthor.text;
    bookInfo.publisher = bookPublishedBy.text;
    bookInfo.publishedDate = bookPublishedYear.text;
    bookInfo.printLength = (NSNumber*)bookPage.text;
    //bookInfo.imageUrl = picUrl;
    bookInfo.price = bookPrice.text;
    bookInfo.bookDescription = bookDesc.text;
    bookInfo.ISBN = resultISBN.text;
    NSData * imageData = UIImageJPEGRepresentation([self imageWithImage:bookImage.image scaledToSize:CGSizeMake(105.0f, 140.0f)],0.6);
    bookInfo.imageUrl = [imageData base64EncodedString];
    
    NSInteger returnCode = [DataLayer addBookToLibrary:bookInfo];
    if(returnCode == 0)
    {
        [Utility Alert:@"" message:@"Added the book to Library successfully!"];
    }else if(returnCode == BookTagAlreadyExists){
        [Utility Alert:@"" message:@"Book tag already exists!"];
    }else {
        [Utility Alert:@"" message:@"Added the book to Library Failed!"];
    }

}

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

-(void)viewWillAppear:(BOOL)animated
{
    self.scrollView.hidden = true;    
    [self scanButtonTapped];
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    
	// Do any additional setup after loading the view.
    self.scrollView.contentSize = CGSizeMake(scrollView.frame.size.width, 600.0f);
    self.scrollView.scrollEnabled = YES;
    
    self.bookDesc.layer.borderWidth = 5.0f;
    self.bookDesc.layer.borderColor = [[UIColor grayColor] CGColor];
    self.bookDesc.autoresizingMask = UIViewAutoresizingFlexibleHeight;
    
    self.bookImage.layer.borderWidth = 2.0f;
    self.bookImage.layer.borderColor = [[UIColor grayColor] CGColor];
    self.bookImage.autoresizingMask = UIViewAutoresizingFlexibleHeight;
    
    // Add touch event gesture in BookImage
    UITapGestureRecognizer *tapGesture = [[UITapGestureRecognizer alloc] initWithTarget:self action:@selector(handleTouchBookImage:)];
    tapGesture.numberOfTapsRequired = 1;
    tapGesture.numberOfTouchesRequired = 1;
    [self.bookImage addGestureRecognizer:tapGesture];
    
    
    // Test Data
    //resultText.text = @"9781840183788";
    //resultText.text = @"9780553281095";
    //[self loadBookInfoFromWeb];
    
//    bookTitle.text = @"Programming WPF";
//    bookAuthor.text = @"Jeffery";
//    bookPublishedBy.text = @"Apress";
//    bookPublishedYear.text = @"2010-12";
//    bookPage.text = @"400";
//    bookPrice.text = @"$20";
//    bookDesc.text = @"description";
//    picUrl = @"http://img3.douban.com/lpic/s4255234.jpg";
//    resultText.text = @"9781840183788";

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

- (BOOL)shouldAutorotate
{
    return NO;
}

@end
