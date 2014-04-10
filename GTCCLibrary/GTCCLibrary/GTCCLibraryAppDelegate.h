//
//  GTCCLibraryAppDelegate.h
//  GTCCLibrary
//
//  Created by Lyle on 6/28/12.
//  Copyright (c) 2012 __MyCompanyName__. All rights reserved.
//

#import <UIKit/UIKit.h>

@class LoginViewController;

@interface GTCCLibraryAppDelegate : UIResponder <UIApplicationDelegate>
@property (retain, nonatomic) UIWindow *window;
@property (nonatomic, retain) IBOutlet LoginViewController *viewController;

@end
