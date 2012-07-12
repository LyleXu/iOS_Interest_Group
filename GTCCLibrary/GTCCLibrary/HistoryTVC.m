//
//  HistoryTVC.m
//  GTCCLibrary
//
//  Created by Lyle on 7/4/12.
//  Copyright (c) 2012 __MyCompanyName__. All rights reserved.
//

#import "HistoryTVC.h"
#import "BookDetailViewController.h"

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
    
    _listData=[NSArray arrayWithObjects:@"aaa",@"bbb",@"ccc",@"ddd",
               @"eee",@"fff",@"ggg",@"hhh",@"iii",@"jjj",@"kkk",@"lll",@"mmm",@"nnn",@"ooo",nil];
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
        
        [segue.destinationViewController setTitle:@"aaa"];
    }
}

#pragma mark - Table view data source


- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
    // Return the number of rows in the section.
    return [_listData count];
}

- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    //返回一行的ou视图
    NSUInteger row=[indexPath row];
    NSString * tableIdentifier=@"CellIdentifier";
    UITableViewCell *cell=[tableView dequeueReusableCellWithIdentifier:tableIdentifier];
    //当一行上滚在屏幕消失时，另一行从屏幕底部滚到屏幕上，如果新行可以直接使用已经滚出屏幕的那行，系统可以避免重新创建和释放视图，同一个TableView,所有的行都是可以复用的，tableIdentifier是用来区别是否属于同一TableView
    
    if(cell==nil)
    {
        //当没有可复用的空闲的cell资源时(第一次载入,没翻页)
        cell=[[UITableViewCell alloc] initWithStyle:UITableViewCellStyleDefault reuseIdentifier:tableIdentifier];
        //UITableViewCellStyleDefault 只能显示一张图片，一个字符串，即本例样式
        //UITableViewCellStyleSubtitle 可以显示一张图片，两个字符串，上面黑色，下面的灰色
        //UITableViewCellStyleValue1 可以显示一张图片，两个字符串，左边的黑色，右边的灰色
        //UITableViewCellStyleValue2 可以显示两个字符串，左边的灰色，右边的黑色
        
    }
    cell.textLabel.text=[_listData objectAtIndex:row];//设置文字
    UIImage *image=[UIImage imageNamed:@"abc"];//读取图片,无需扩展名
    cell.imageView.image=image;//文字左边的图片
    
    //    cell.detailTextLabel.text=@"详细描述"; 适用于Subtitle，Value1，Value2样式
    //    cell.imageView.highlightedImage=image; 可以定义被选中后显示的图片
    return cell;
}

#pragma mark - Table view delegate

- (void)tableView:(UITableView *)tableView didSelectRowAtIndexPath:(NSIndexPath *)indexPath
{
/*
    NSString * string=[_listData objectAtIndex:[indexPath row]];
    //取出被选中项的文字
    UIAlertView *alert=[[UIAlertView alloc] initWithTitle:@"提示" message:string delegate:self cancelButtonTitle:@"确定" otherButtonTitles: nil];
    [alert show];
 */


    
}




@end
