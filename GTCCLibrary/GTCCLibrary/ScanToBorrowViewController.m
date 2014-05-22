//
//  ScanToBorrowViewController.m
//  GTCC Library
//
//  Created by gtcc on 4/29/14.
//
//

#import "ScanToBorrowViewController.h"
#import "ZBarReaderViewController.h"
#import "DataLayer.h"
#import "Utility.h"
@interface ScanToBorrowViewController ()

@end
NSString* ISBN;
NSMutableArray* tagList;
@implementation ScanToBorrowViewController
@synthesize bookAuthor,bookDesc,bookImage,bookISBN,bookPage,bookPrice,bookPublishedBy,bookPublishedYear,bookTitle;

- (void) scanButtonTapped
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
    }
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
        ISBN = symbol.data;
        
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
        
        [HUD showWhileExecuting:@selector(loadBookInfo) onTarget:self withObject:nil animated:YES];
    }
}

-(void)loadBookInfo
{
    // empty the previous book info
    [self emptyControlValue];

    // get the booklist by ISBN
    NSMutableArray* bookList =[DataLayer getBookListbyISBN:ISBN];
    if([bookList count])
    {
        [self initTagList:bookList];
        [self initTagPickerView];
        
        CBook* book = bookList[0];
        [self updateControlValue:book];
    }
    else
    {
         [Utility Alert:@"" message:@"Please add the book to library at first!"];
    }
    
    //To set whether 'Borrow' button is enabled or not
    if ([bookList count] > 0) {
        self.navigationItem.rightBarButtonItem.enabled = true;
    }
    else{
        self.navigationItem.rightBarButtonItem.enabled = false;
    }
        
    //self.navigationItem.rightBarButtonItem.enabled = [bookList count];
}

-(void)initTagList:(NSMutableArray*)bookList
{
    tagList = [NSMutableArray array];
    for (CBook* item in bookList) {
        [tagList addObject:item.bianhao];
    }
}

-(void)initTagPickerView
{
    UIPickerView* pickerView = [[UIPickerView alloc] init];
    [pickerView sizeToFit];
    pickerView.autoresizingMask = (UIViewAutoresizingFlexibleWidth | UIViewAutoresizingFlexibleHeight);
    pickerView.delegate = self;
    pickerView.dataSource = self;
    pickerView.showsSelectionIndicator = YES;
    
    self.tagPickerView = pickerView;
    self.txtTag.inputView = self.tagPickerView;
}

-(void)emptyControlValue
{
    dispatch_async(dispatch_get_main_queue(), ^{
        self.bookTitle.text = nil;
        self.bookAuthor.text = nil;
        self.bookDesc.text = nil;
        self.bookPage.text = nil;
        self.bookPublishedBy.text = nil;
        self.bookPublishedYear.text = nil;
        self.bookPrice.text = nil;
        self.bookISBN.text = nil;
        self.txtTag.text = nil;
        self.bookImage.image = nil;
    });
}

-(void)updateControlValue:(CBook*)book
{
    self.bookTitle.text = book.title;
    self.bookAuthor.text = book.author;
    dispatch_async(dispatch_get_main_queue(), ^{
        self.bookDesc.text = book.bookDescription;
    });
    
    self.bookPage.text = [book.printLength stringValue];
    self.bookPublishedBy.text = book.publisher;
    self.bookPublishedYear.text = book.publishedDate;
    self.bookPrice.text = book.price;
    self.bookISBN.text = ISBN;
    self.txtTag.text = book.bianhao;
    self.bookImage.image = [Utility getImageFromUrl:ISBN];
}

-(void)viewWillAppear:(BOOL)animated
{
    [self scanButtonTapped];
}

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (IBAction)BorrowBook:(id)sender {
    UIActionSheet *actionSheet = [[UIActionSheet alloc] initWithTitle:@"Are you sure to borrow the book?" delegate:self cancelButtonTitle:@"No, thanks!" destructiveButtonTitle:@"Yes, I'm sure!" otherButtonTitles: nil];
    
    [actionSheet showInView:self.view];
}

-(void)actionSheet:(UIActionSheet *)actionSheet didDismissWithButtonIndex:(NSInteger)buttonIndex
{
    if(buttonIndex != [actionSheet cancelButtonIndex])
    {
        NSString* username =  [Utility getUsername];
        NSString* bookBianhao = self.txtTag.text;
        
        NSInteger result = [DataLayer Borrow:username bookBianhao:bookBianhao];
        if(result == 0)
        {
            // alert borrow sucessfully
            [Utility Alert:@"" message:@"Borrowed successfully!"];
        }else if(result == CannnotBorrowExceeding3)
        {
            [Utility Alert:@"" message:@"You can only borrow 3 books at a time!"];
        }
        else
        {
            [Utility Alert:@"" message:@"Borrowed Failed! It may be borrowed by others."];
        }
    }
}

-(NSInteger)numberOfComponentsInPickerView:(UIPickerView *)pickerView
{
    return 1;
}

-(NSInteger)pickerView:(UIPickerView *)pickerView numberOfRowsInComponent:(NSInteger)component
{
    return [tagList count];
}

-(NSString*)pickerView:(UIPickerView *)pickerView titleForRow:(NSInteger)row forComponent:(NSInteger)component
{
    return [tagList objectAtIndex:row];
}

-(void)pickerView:(UIPickerView *)pickerView didSelectRow:(NSInteger)row inComponent:(NSInteger)component
{
    NSString* tag = [tagList objectAtIndex:row];
    self.txtTag.text = tag;
    [self.txtTag resignFirstResponder];
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    // Do any additional setup after loading the view.
    
    self.scrollView.contentSize = CGSizeMake(self.scrollView.frame.size.width, 600.0f);
    self.scrollView.scrollEnabled = YES;
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

/*
#pragma mark - Navigation

// In a storyboard-based application, you will often want to do a little preparation before navigation
- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender
{
    // Get the new view controller using [segue destinationViewController].
    // Pass the selected object to the new view controller.
}
*/

@end
