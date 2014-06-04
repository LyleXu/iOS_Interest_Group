//
//  LoginViewController.m
//  QQDemo
//
//  Created by DotHide on 11-8-3.
//  Copyright 2011 __MyCompanyName__. All rights reserved.
//

#import "LoginViewController.h"
#import "DataLayer.h"
#import "GTCCTabBarController.h"
#import "Constraint.h"
#import "Utility.h"
#define kLeftMargin				20.0
#define kRightMargin			20.0

#define kTextFieldWidth			160.0
#define kTextFieldHeight		25

#define kViewTag				100

static NSString *kSourceKey = @"sourceKey";
static NSString *kViewKey = @"viewKey";

@implementation LoginViewController

@synthesize loginTableView, logoImageView;
@synthesize btnLogin, btnCancel;
@synthesize txtUser,txtPass;
@synthesize dataArray; 


// The designated initializer.  Override if you create the controller programmatically and want to perform customization that is not appropriate for viewDidLoad.
/*
- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil {
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization.
    }
    return self;
}
*/


// Implement viewDidLoad to do additional setup after loading the view, typically from a nib.
- (void)viewDidLoad {
    [super viewDidLoad];
	
	self.dataArray = [NSArray arrayWithObjects:
					  [NSDictionary dictionaryWithObjectsAndKeys:
					   @"Username: ",kSourceKey,
					   self.txtUser,kViewKey,
					   nil],
					  [NSDictionary dictionaryWithObjectsAndKeys:
					   @"Password: ",kSourceKey,
					   self.txtPass,kViewKey,
					   nil],
					  nil];
	self.editing = NO;
}

/*
// Override to allow orientations other than the default portrait orientation.
- (BOOL)shouldAutorotateToInterfaceOrientation:(UIInterfaceOrientation)interfaceOrientation {
    // Return YES for supported orientations.
    return (interfaceOrientation == UIInterfaceOrientationPortrait);
}
*/

- (void)didReceiveMemoryWarning {
    // Releases the view if it doesn't have a superview.
    [super didReceiveMemoryWarning];
    
    // Release any cached data, images, etc. that aren't in use.
}

- (void)viewDidUnload {
    [super viewDidUnload];
    // Release any retained subviews of the main view.
    // e.g. self.myOutlet = nil;

	txtUser = nil;

	txtPass = nil;
	self.dataArray = nil;
}


- (void)dealloc {

}

- (void)touchesBegan:(NSSet *)touches withEvent:(UIEvent *)event{
	[txtUser resignFirstResponder];
	[txtPass resignFirstResponder];
}

#pragma mark UITableViewDataSource methods
/*
- (NSInteger)numberOfSectionsInTableView:(UITableView *)tableView{
	return 1;
}
 */

- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section{
	return 2;
}

- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath{
	NSString *identifier = @"loginCell";
	UITableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:identifier];
	if (!cell) {
		//cell = [[[UITableViewCell alloc] initWithStyle:UITableViewCellStyleDefault 
									  // reuseIdentifier:identifier] autorelease];
	}else {
		UIView *viewToCheck = nil;
		viewToCheck = [cell.contentView viewWithTag:kViewTag];
		if (viewToCheck) {
			[viewToCheck removeFromSuperview];
		}
	}
	cell.selectionStyle = UITableViewCellSelectionStyleNone;
	//配置单元格
	cell.textLabel.text = [[dataArray objectAtIndex:indexPath.row] valueForKey:kSourceKey];
	UITextField *tmpTxtField = [[self.dataArray objectAtIndex:indexPath.row] valueForKey:kViewKey];
	[cell.contentView addSubview:tmpTxtField];
	
	return cell;
}


#pragma mark -
#pragma mark TextFields

- (UITextField *)txtUser{
	if (txtUser == nil) {
		CGRect frame = CGRectMake(kLeftMargin + 110, 10.0, kTextFieldWidth, kTextFieldHeight);
		txtUser = [[UITextField alloc] initWithFrame:frame];
		txtUser.borderStyle = UITextBorderStyleNone;
		txtUser.textColor = [UIColor blackColor];
		txtUser.font = [UIFont systemFontOfSize:17];
		txtUser.placeholder = @" Your Username";
		txtUser.backgroundColor = [UIColor whiteColor];
		txtUser.autocorrectionType = UITextAutocorrectionTypeNo;
		txtUser.keyboardType = UIKeyboardTypeDefault;
		txtUser.clearButtonMode = UITextFieldViewModeWhileEditing;
		txtUser.tag = kViewTag;
		txtUser.delegate = self;
	}
	return txtUser;
}

- (UITextField *)txtPass{
	if (txtPass == nil) {
		CGRect frame = CGRectMake(kLeftMargin + 110, 10.0, kTextFieldWidth, kTextFieldHeight);
		txtPass = [[UITextField alloc] initWithFrame:frame];
		txtPass.borderStyle = UITextBorderStyleNone;
		txtPass.textColor = [UIColor blackColor];
		txtPass.font = [UIFont systemFontOfSize:17];
		txtPass.placeholder = @" Your Password";
		txtPass.backgroundColor = [UIColor whiteColor];
		txtPass.autocorrectionType = UITextAutocorrectionTypeNo;
		txtPass.keyboardType = UIKeyboardTypeDefault;
		txtPass.returnKeyType = UIReturnKeyDone;
		txtPass.clearButtonMode = UITextFieldViewModeWhileEditing;
		txtPass.tag = kViewTag;
		txtPass.delegate = self;
        txtPass.secureTextEntry = YES; // Make password display "*******"
	}
	return txtPass;
}

#pragma mark UITextFieldDelegate methods
- (BOOL)textFieldShouldReturn:(UITextField *)textField{
	[textField resignFirstResponder];
	return YES;
}

- (BOOL)textFieldShouldBeginEditing:(UITextField *)textField{
	NSUInteger distance;
	CGContextRef context = UIGraphicsGetCurrentContext();
	[UIView beginAnimations:nil context:context];
	[UIView setAnimationCurve:UIViewAnimationCurveEaseInOut];
	[UIView setAnimationDuration:0.3];
	self.logoImageView.alpha = 0.0f;
	
	CGRect frame = self.loginTableView.frame;
	CGRect frame2 = self.btnLogin.frame;
	distance = frame2.origin.y - frame.origin.y;
	frame.origin.y = 20.0;
	self.loginTableView.frame = frame;
	frame2.origin.y = frame.origin.y + distance;
	self.btnLogin.frame = frame2;
	CGRect frame3 = self.btnCancel.frame;
	frame3.origin.y = frame2.origin.y;
	self.btnCancel.frame = frame3;
	
	[UIView commitAnimations];
	return YES;
}

- (IBAction)Login:(id)sender {
    if([DataLayer Login:self.txtUser.text password:self.txtPass.text])
    {
        // Save the user info to NSDefult
        NSUserDefaults *mydefault = [NSUserDefaults standardUserDefaults];
        [mydefault setObject:txtUser.text forKey:USERNAME];
        [mydefault synchronize];
        
        [self performSegueWithIdentifier:@"DoLogin" sender:self];
    }
    else{
        [Utility Alert:@"Login Failed" message:@"Please input correct username and password"];
    }
}

@end
