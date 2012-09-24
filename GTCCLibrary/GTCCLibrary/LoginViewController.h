//
//  LoginViewController.h
//  QQDemo
//
//  Created by DotHide on 11-8-3.
//  Copyright 2011 __MyCompanyName__. All rights reserved.
//

#import <UIKit/UIKit.h>

@protocol LoginViewControllerDelegate;
@interface LoginViewController : UIViewController <UITableViewDataSource, UITextFieldDelegate> {
	IBOutlet UITableView *loginTableView;
	IBOutlet UIImageView *logoImageView;
	UIButton *btnLogin;
	UIButton *btnCancel;
	
	UITextField *txtUser;
	UITextField *txtPass;
	
	NSArray *dataArray;
}

@property (nonatomic, retain) IBOutlet UITableView *loginTableView;
@property (nonatomic, retain) IBOutlet UIImageView *logoImageView;
@property (nonatomic, retain) IBOutlet UIButton *btnLogin;
@property (nonatomic, retain) IBOutlet UIButton *btnCancel;
@property (nonatomic, retain) UITextField *txtUser;
@property (nonatomic, retain) UITextField *txtPass;
@property (nonatomic, retain) NSArray *dataArray;


@end

