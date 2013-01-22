//
//  HistoryTVC.h
//  GTCCLibrary
//
//  Created by Lyle on 7/4/12.
//  Copyright (c) 2012 __MyCompanyName__. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface BookstoreTVC : UITableViewController<UITableViewDelegate,UITableViewDataSource>

@property (nonatomic,strong) NSArray * listData;
@property (nonatomic, retain) NSMutableArray *filteredListData;           

@end
