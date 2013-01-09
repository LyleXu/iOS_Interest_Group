//
//  HistoryTVC.m
//  GTCCLibrary
//
//  Created by Lyle on 7/4/12.
//  Copyright (c) 2012 __MyCompanyName__. All rights reserved.
//

#import "HistoryTVC.h"
#import "BookDetailViewController.h"
#import "SBJson.h"
#import "SBJsonWriter.h"
#import "DataLayer.h"
#import "CBook.h"
#import "Utility.h"

@implementation HistoryTVC

@synthesize listData = _listData;
@synthesize filteredListData = _filteredListData;


- (id)initWithStyle:(UITableViewStyle)style
{
    self = [super initWithStyle:style];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)didReceiveMemoryWarning
{
    // Releases the view if it doesn't have a superview.
    [super didReceiveMemoryWarning];
    
    // Release any cached data, images, etc that aren't in use.
}


#pragma mark - View lifecycle

- (void)viewDidLoad
{
    [super viewDidLoad];

    // Uncomment the following line to preserve selection between presentations.
    // self.clearsSelectionOnViewWillAppear = NO;
 
    // Uncomment the following line to display an Edit button in the navigation bar for this view controller.
    // self.navigationItem.rightBarButtonItem = self.editButtonItem;  
    
    self.navigationItem.title = @"Book Store";
    
    _listData = [DataLayer GetAllBooks];
    
    self.filteredListData = [NSMutableArray arrayWithCapacity:[self.listData count]];
}

- (void)viewDidUnload
{
    [super viewDidUnload];
    // Release any retained subviews of the main view.
    // e.g. self.myOutlet = nil;
    
    self.listData = nil;
    self.filteredListData = nil;
}

- (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation
{
    // Return YES for supported orientations
    return (interfaceOrientation == UIInterfaceOrientationPortrait);
}


- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender
{
    
    if ([segue.identifier isEqualToString:@"BookDetail"]) {
        NSUInteger rowIndex = [[self.tableView indexPathForSelectedRow] row];
        CBook* book = [_listData objectAtIndex:rowIndex];
        BookDetailViewController* controller = segue.destinationViewController;
        controller.bookInfo = book;
        [controller setTitle:book.title];
        
    }
     
}


#pragma mark - Table view data source


- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
	if (tableView == self.searchDisplayController.searchResultsTableView)
	{
        return [self.filteredListData count];
    }
	else
	{
        return [self.listData count];
    }
}

- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    NSUInteger row=[indexPath row];
    NSString * tableIdentifier=@"CellIdentifier";
    UITableViewCell *cell=[tableView dequeueReusableCellWithIdentifier:tableIdentifier];

    if(cell==nil)
    {
        // first load
        cell=[[UITableViewCell alloc] initWithStyle:UITableViewCellStyleDefault reuseIdentifier:tableIdentifier];
        
    }
    
    CBook * book = nil;
    if(tableView == self.searchDisplayController.searchResultsTableView)
    {
        book =  [self.filteredListData objectAtIndex:row];
    }else {
        book = [self.listData objectAtIndex:row];
    }
    
    cell.textLabel.text= book.title;
    
    UIImage * imageFromURL = [Utility getImageFromUrl:book.title];
    cell.imageView.image=imageFromURL;
    
    return cell;
}
CGCONTEXT_H_
-(void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath
{
    
	/*
	 If the requesting table view is the search display controller's table view, configure the next view controller using the filtered content, otherwise use the main list.
	 */
	CBook *book = nil;
	if (tableView == self.searchDisplayController.searchResultsTableView)
	{
        
        BookDetailViewController* detailsViewController = [[BookDetailViewController alloc] init];
        book = [self.filteredListData objectAtIndex:indexPath.row];
        
        detailsViewController.title = book.title;
        detailsViewController.bookInfo = book;
        [self.navigationController pushViewController:detailsViewController animated:YES];
    }else {
        book = [self.listData objectAtIndex:indexPath.row];
    }
    
    

}

#pragma mark - Table view delegate

#pragma mark -
#pragma mark Content Filtering

- (void)filterContentForSearchText:(NSString*)searchText
{
	/*
	 Update the filtered array based on the search text and scope.
	 */
	
	[self.filteredListData removeAllObjects]; // First clear the filtered array.
	
	/*
	 Search the main list for products whose type matches the scope (if selected) and whose name matches searchText; add items that match to the filtered array.
	 */
	for (CBook *book in self.listData)
	{

        NSComparisonResult result = [book.title compare:searchText options:(NSCaseInsensitiveSearch|NSDiacriticInsensitiveSearch) range:NSMakeRange(0, [searchText length])];
        if (result == NSOrderedSame)
        {
            [self.filteredListData addObject:book];
        }
	}
}


#pragma mark -
#pragma mark UISearchDisplayController Delegate Methods

- (BOOL)searchDisplayController:(UISearchDisplayController *)controller shouldReloadTableForSearchString:(NSString *)searchString
{
    [self filterContentForSearchText:searchString];
    
    // Return YES to cause the search result table view to be reloaded.
    return YES;
}



@end
