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

@synthesize sectionNames = _sectionNames;
@synthesize sectionData = _sectionData;
@synthesize filteredListData = _filteredListData;
@synthesize isSearching;

-(NSMutableArray*)sectionData
{
    if(_sectionData == nil)
    {
        _sectionData = [[NSMutableArray alloc] init];
        _sectionNames = [[NSMutableArray alloc] init];
        
        NSMutableArray* allBooks = [DataLayer GetAllBooks:@"0" count:@""];
        
        NSSortDescriptor *sortDescriptor;
        sortDescriptor = [[NSSortDescriptor alloc] initWithKey:@"bianhao"
                                                     ascending:YES];
        NSArray *sortDescriptors = [NSArray arrayWithObject:sortDescriptor];
        NSArray *sortedArray;
        sortedArray = [allBooks sortedArrayUsingDescriptors:sortDescriptors];
        
        NSString* sectionName = nil;
        NSString* previous = @"";
        // prepare the sections
        for (CBook* book in sortedArray) {
            // Get the first character from book tag
            if([book.bianhao length] > 0)
            {
                NSString* firstLetter = [book.bianhao substringToIndex:1];
                sectionName = [[Utility getBookCategory] objectForKey:firstLetter];
                
                if(sectionName)
                {
                    if(![firstLetter isEqualToString: previous])
                    {
                        previous = firstLetter;
                        [_sectionNames addObject: sectionName];
                        // and in that case, also add a new subarray to our array of subarrays
                        NSMutableArray* oneSection = [NSMutableArray array];
                        [_sectionData addObject: oneSection];
                    }
                    
                    [[_sectionData lastObject] addObject: book];
                }
                
            }
            
        }
    }
    return _sectionData;
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
    
    // Hide the searchbar, the user can pull to display the searchbar
    self.tableView.tableHeaderView = self.searchBar;
    self.tableView.contentOffset = CGPointMake(0, CGRectGetHeight(self.searchBar.bounds));
    
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
    
    self.sectionData = nil;
    self.filteredListData = nil;
    self.sectionNames = nil;
}

- (BOOL)shouldAutorotate
{
    return NO;
}


- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender
{
    
    if ([segue.identifier isEqualToString:@"BookDetail"]) {

        NSIndexPath* indexPath = [self.tableView indexPathForSelectedRow];
        
        NSArray* model = isSearching ? self.filteredListData : self.sectionData;
        
        CBook* book = model[indexPath.section][indexPath.row];
        
        BookDetailViewController* controller = segue.destinationViewController;
        controller.bookInfo = book;
        
    }
     
}


#pragma mark - Table view data source

- (NSInteger)numberOfSectionsInTableView:(UITableView *)tableView{
    return [self.sectionData count];
}

- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
    NSArray* model = (tableView == self.searchDisplayController.searchResultsTableView) ? self.filteredListData : self.sectionData;
	return [model[section] count];
}

- (NSString *)tableView:(UITableView *)tableView titleForHeaderInSection:(NSInteger)section
{
    return self.sectionNames[section];
}

- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    NSString * tableIdentifier=@"CellIdentifier";
    UITableViewCell *cell=[tableView dequeueReusableCellWithIdentifier:tableIdentifier];

    if(cell==nil)
    {
        // first load
        cell=[[UITableViewCell alloc] initWithStyle:UITableViewCellStyleDefault reuseIdentifier:tableIdentifier];
        
    }
    
    NSArray* model = (tableView == self.searchDisplayController.searchResultsTableView) ? self.filteredListData : self.sectionData;
    
    CBook* book = model[indexPath.section][indexPath.row];
    
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
    NSString *string =self.sectionNames[section];
    [label setText:string];
    [view addSubview:label];

    return view;
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
    NSPredicate* p = [NSPredicate predicateWithBlock:
                      ^BOOL(id obj, NSDictionary *d) {
                          CBook* s = obj;
                          NSStringCompareOptions options = NSCaseInsensitiveSearch;
                          return ([s.title rangeOfString:searchText
                                           options:options].location != NSNotFound);
                      }];
    NSMutableArray* filteredData = [NSMutableArray new];
    // sectionData is an array of arrays
    // for every array ...
    for (NSMutableArray* arr in self.sectionData) {
        // generate an array of strings passing the search criteria
        [filteredData addObject: [arr filteredArrayUsingPredicate:p]];
    }
    self.filteredListData = filteredData;
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
    
    self.sectionData = nil;
    self.sectionNames = nil;
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
