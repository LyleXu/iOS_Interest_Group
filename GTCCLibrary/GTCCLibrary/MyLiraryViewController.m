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
#import "BorrowedBookTableViewCell.h"
@interface MyLiraryViewController ()

@end

@implementation MyLiraryViewController
@synthesize borrowedBooks = _borrowedBooks;
- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

-(NSMutableArray*)borrowedBooks
{
    if(_borrowedBooks == nil)
    {
        NSString* username = [Utility getUsername];
        _borrowedBooks = [DataLayer getBorrowInfo:username];
    }
    
    return _borrowedBooks;
}

-(NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
    return [self.borrowedBooks count];
}

-(UITableViewCell*)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    NSString * tableIdentifier=@"BorrowedBookCell";
    BorrowedBookTableViewCell *cell=[tableView dequeueReusableCellWithIdentifier:tableIdentifier];
    
    if(cell==nil)
    {
        // first load
        cell=[[BorrowedBookTableViewCell alloc] initWithStyle:UITableViewCellStyleDefault reuseIdentifier:tableIdentifier];
    }
    
    CBorrowHistory* book = [self.borrowedBooks objectAtIndex:indexPath.row];
    
    cell.lblTitle.text = book.bookName;
    cell.borrowedDate.text = book.borrowDate;
    cell.dueDate.text = book.planReturnDate;
    
    UIImage * imageFromURL = [Utility getImageFromUrl:book.ISBN];
    cell.imageView.image = imageFromURL;
    
    return cell;
}

-(void)viewWillAppear:(BOOL)animated
{
    [self refresh];
}

-(void)refresh
{
    self.borrowedBooks = nil;
    self.navigationItem.rightBarButtonItem = nil;
    
    if ([self.borrowedBooks count]) {
        self.navigationItem.rightBarButtonItem = [[UIBarButtonItem alloc] initWithTitle:@"Return" style:UIBarButtonItemStyleBordered target:self action:@selector(doReturnBook)];
        
        self.myBookTableView.hidden = false;
    }else
    {
        self.myBookTableView.hidden = true;
    }
    
    [self.myBookTableView reloadData];
}

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view.

}

- (void)viewDidUnload
{
    [super viewDidUnload];
    // Release any retained subviews of the main view.
}

- (BOOL)shouldAutorotate
{
    return NO;
}

- (void)doReturnBook
{
    UIActionSheet *actionSheet = [[UIActionSheet alloc] initWithTitle:@"Are you sure to return the book?"
                                                             delegate:self
                                                    cancelButtonTitle:@"No, thanks!" destructiveButtonTitle:@"Yes, I’m Sure!" otherButtonTitles:nil];
    [actionSheet showInView:self.view];
}

-(void)actionSheet:(UIActionSheet *)actionSheet didDismissWithButtonIndex:(NSInteger)buttonIndex
{
    if( buttonIndex != [actionSheet cancelButtonIndex])
    {
        NSString* username = [Utility getUsername];
        
        NSIndexPath* indexpath = [self.myBookTableView indexPathForSelectedRow];
        if(indexpath != nil)
        {
            CBorrowHistory* book = [self.borrowedBooks objectAtIndex:indexpath.row];
            if([DataLayer ReturnBook:username bookBianhao:book.bookBianhao])
            {
                [Utility Alert:@"" message:@"Returned successfully!"];
                [self refresh];
            }else
            {
                [Utility Alert:@"" message:@"Returned failed!"];
            }
        }else
        {
             [Utility Alert:@"" message:@"No book is selected!"];
        }
    }
}

@end
