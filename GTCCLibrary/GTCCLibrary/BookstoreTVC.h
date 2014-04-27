//
//  HistoryTVC.h
//  GTCCLibrary
//
//  Created by Lyle on 7/4/12.
//  Copyright (c) 2012 __MyCompanyName__. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "EGORefreshTableHeaderView.h"
@interface BookstoreTVC : UITableViewController<EGORefreshTableHeaderDelegate,UITableViewDelegate,UITableViewDataSource>
{	
	EGORefreshTableHeaderView *_refreshHeaderView;	
	//  Reloading var should really be your tableviews datasource
	//  Putting it here for demo purposes 
	BOOL _reloading;
}
@property (nonatomic,strong) NSMutableArray * sectionData;
@property (nonatomic, retain) NSMutableArray *filteredListData;
@property (nonatomic, retain) NSMutableArray *sectionNames;
@property (nonatomic, assign) BOOL isSearching;
- (void)reloadTableViewDataSource;
@property (weak, nonatomic) IBOutlet UISearchBar *searchBar;
- (void)doneLoadingTableViewData;
@end
