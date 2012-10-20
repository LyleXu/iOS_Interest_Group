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
    
    _listData = [DataLayer GetAllBooks];
}

- (void)viewDidUnload
{
    [super viewDidUnload];
    // Release any retained subviews of the main view.
    // e.g. self.myOutlet = nil;
    
    _listData=nil;
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
    return [_listData count];
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
    
    CBook * book = [_listData objectAtIndex:row];
    
    cell.textLabel.text= book.title;
    
    UIImage * imageFromURL = [Utility getImageFromUrl:book.title];
    cell.imageView.image=imageFromURL;
    
    return cell;
}

#pragma mark - Table view delegate

@end
