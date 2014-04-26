//
//  HistoryTVC.m
//  GTCCLibrary
//
//  Created by Lyle on 7/4/12.
//  Copyright (c) 2012 __MyCompanyName__. All rights reserved.
//

#import "BookstoreTVC.h"
#import "BookDetailViewController.h"
#import "SBJson.h"
#import "SBJsonWriter.h"
#import "DataLayer.h"
#import "CBook.h"
#import "Utility.h"

@implementation BookstoreTVC

@synthesize listData = _listData;
@synthesize filteredListData = _filteredListData;
@synthesize isSearching;

-(NSMutableDictionary*)listData
{
    if(_listData == nil)
    {
        NSString* offset = @"0";
        NSString* count = @"";      // empty means that we get all books
        NSMutableArray* tempAllBooks = [DataLayer GetAllBooks:offset count:count];
        _listData = [[NSMutableDictionary alloc] init];
        
        
        NSString* sectionKey = nil;
        // prepare the sections
        for (CBook* book in tempAllBooks) {
            // Get the first character from book tag
            if(book.bianhao != [NSNull null] && [book.bianhao length] > 0)
            {
                NSString* firstLetter = [book.bianhao substringWithRange: NSMakeRange(0, 1)];
                sectionKey = [[Utility getBookCategory] objectForKey:firstLetter];
                if (sectionKey) {
                    NSMutableArray* object = [_listData objectForKey:sectionKey];
                    if(object)
                    {
                        [object addObject:book];
                    }else
                    {
                        NSMutableArray* array = [[NSMutableArray alloc] init];
                        [array addObject:book];
                        [_listData setObject:array forKey:sectionKey];
                    }
                }
                
            }
        }
    }
    return _listData;
}

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
    
    self.edgesForExtendedLayout = UIRectEdgeNone;   // otherise, section header won't float in iOS7
    
    self.filteredListData = [NSMutableArray arrayWithCapacity:[self.listData count]];
    
    if (_refreshHeaderView == nil) {
		
		EGORefreshTableHeaderView *view = [[EGORefreshTableHeaderView alloc] initWithFrame:CGRectMake(0.0f, 0.0f - self.tableView.bounds.size.height, self.view.frame.size.width, self.tableView.bounds.size.height)];
		view.delegate = self;
		[self.tableView addSubview:view];
		_refreshHeaderView = view;
		
	}
	
	//  update the last update date
	[_refreshHeaderView refreshLastUpdatedDate];
}

- (void)viewDidUnload
{
    [super viewDidUnload];
    // Release any retained subviews of the main view.
    // e.g. self.myOutlet = nil;
    
    self.listData = nil;
    self.filteredListData = nil;
}

- (BOOL)shouldAutorotate
{
    return NO;
}


- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender
{
    
    if ([segue.identifier isEqualToString:@"BookDetail"]) {

//        NSUInteger rowIndex = [[self.tableView indexPathForSelectedRow] row];
//        CBook* book = nil;
//        if(isSearching)
//        {
//            book = [self.filteredListData objectAtIndex:rowIndex];
//        }else {
//            
//            book = [self.listData objectAtIndex:rowIndex];
//        }
//        BookDetailViewController* controller = segue.destinationViewController;
//        controller.bookInfo = book;
        
    }
     
}


#pragma mark - Table view data source

- (NSInteger)numberOfSectionsInTableView:(UITableView *)tableView{
    
    return [self.listData count];
}

- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
//	if (tableView == self.searchDisplayController.searchResultsTableView)
//	{
//        return [self.filteredListData count];
//    }
//	else
//	{
//        return [self.listData count];
//    }
    NSString *aSection = self.listData.allKeys[section];
    id theData = self.listData[aSection];
    return [theData count];
}

- (NSString *)tableView:(UITableView *)tableView titleForHeaderInSection:(NSInteger)section
{
    return self.listData.allKeys[section];
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
        NSString *aSection = self.listData.allKeys[indexPath.section];
        book = self.listData[aSection][indexPath.row];
    }
    
    cell.textLabel.text= book.title;
    
    UIImage * imageFromURL = [Utility getImageFromUrl:book.ISBN];
    cell.imageView.image=imageFromURL;
    
    return cell;
}

-(UIView *)tableView:(UITableView *)tableView viewForHeaderInSection:(NSInteger)section
{
    UIView *view = [[UIView alloc] initWithFrame:CGRectMake(0, 0, tableView.frame.size.width, 30.0)];
    /* Create custom view to display section header... */
    UILabel *label = [[UILabel alloc] initWithFrame:CGRectMake(0, 0, tableView.frame.size.width, 30.0)];
    [label setFont:[UIFont boldSystemFontOfSize:12]];
    [label setBackgroundColor:[UIColor colorWithRed:166/255.0 green:177/255.0 blue:186/255.0 alpha:1.0]]; //your background
    NSString *string =self.listData.allKeys[section];
    [label setText:string];
    [view addSubview:label];

    return view;
}

-(NSInteger)tableView:(UITableView *)tableView sectionForSectionIndexTitle:(NSString *)title atIndex:(NSInteger)index
{
    
}

CGCONTEXT_H_
-(void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath
{
    
	/*
	 If the requesting table view is the search display controller's table view, configure the next view controller using the filtered content, otherwise use the main list.
	 */
	if (tableView == self.searchDisplayController.searchResultsTableView)
	{
        isSearching = true;
        [self performSegueWithIdentifier:@"BookDetail" sender:self];
    }else {
        isSearching = false;
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

#pragma mark -
#pragma mark Data Source Loading / Reloading Methods

- (void)reloadTableViewDataSource{
	
	//  should be calling your tableviews data source model to reload
	//  put here just for demo
	_reloading = YES;
    
    NSString* offset = @"0";
    NSString* count = @"";
    _listData = [DataLayer GetAllBooks:offset count:count];
    //_listData = [DataLayer GetAllBooks];
    
    self.filteredListData = [NSMutableArray arrayWithCapacity:[self.listData count]];
}

- (void)doneLoadingTableViewData{
	
	//  model should call this when its done loading
	_reloading = NO;
	[_refreshHeaderView egoRefreshScrollViewDataSourceDidFinishedLoading:self.tableView];
    
    [self.tableView reloadData];
	
}


#pragma mark -
#pragma mark UIScrollViewDelegate Methods

- (void)scrollViewDidScroll:(UIScrollView *)scrollView{	
	
	[_refreshHeaderView egoRefreshScrollViewDidScroll:scrollView];
    
}

- (void)scrollViewDidEndDragging:(UIScrollView *)scrollView willDecelerate:(BOOL)decelerate{
	
	[_refreshHeaderView egoRefreshScrollViewDidEndDragging:scrollView];
	
}


#pragma mark -
#pragma mark EGORefreshTableHeaderDelegate Methods

- (void)egoRefreshTableHeaderDidTriggerRefresh:(EGORefreshTableHeaderView*)view{
	
	[self reloadTableViewDataSource];
	[self performSelector:@selector(doneLoadingTableViewData) withObject:nil afterDelay:3.0];
	
}

- (BOOL)egoRefreshTableHeaderDataSourceIsLoading:(EGORefreshTableHeaderView*)view{
	
	return _reloading; // should return if data source model is reloading
	
}

- (NSDate*)egoRefreshTableHeaderDataSourceLastUpdated:(EGORefreshTableHeaderView*)view{
	
	return [NSDate date]; // should return date data source was last changed
	
}
@end
