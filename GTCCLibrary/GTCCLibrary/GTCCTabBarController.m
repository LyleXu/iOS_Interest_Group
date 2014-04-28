//
//  GTCCTabBarController.m
//  GTCCLibrary
//
//  Created by Lyle on 9/19/12.
//  Copyright (c) 2012 __MyCompanyName__. All rights reserved.
//

#import "GTCCTabBarController.h"
#import "Utility.h"
#import "ScanViewController.h"
@implementation GTCCTabBarController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
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

/*
// Implement loadView to create a view hierarchy programmatically, without using a nib.
- (void)loadView
{
}
*/

// Implement viewDidLoad to do additional setup after loading the view, typically from a nib.
- (void)viewDidLoad
{
    [super viewDidLoad];
    
    // Remove the Scan tab if the user is not Admin
    if([@"admin" caseInsensitiveCompare:[Utility getUsername]]!= NSOrderedSame)
    {
        NSMutableArray *navControllers = [NSMutableArray arrayWithArray: self. viewControllers];
        for (id controller in navControllers) {
            NSMutableArray *subcontrollers = [NSMutableArray arrayWithArray: [controller viewControllers]];
            if([subcontrollers[0] isKindOfClass:[ScanViewController class]]){
                    [navControllers removeObject:controller];
                    break;
            }
        }
        
        [self  setViewControllers: navControllers ];
    }
}

- (void)viewDidUnload
{
    [super viewDidUnload];
    // Release any retained subviews of the main view.
    // e.g. self.myOutlet = nil;
}

// dropped in iOS7
//- (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation
//{
//    // Return YES for supported orientations
//    return (interfaceOrientation == UIInterfaceOrientationPortrait);
//}
- (BOOL)shouldAutorotate
{
    return NO;
}

@end
