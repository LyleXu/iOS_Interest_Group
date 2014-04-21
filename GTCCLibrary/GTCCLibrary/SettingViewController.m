//
//  SettingViewController.m
//  GTCC Library
//
//  Created by gtcc on 4/21/14.
//
//

#import "SettingViewController.h"
#import "Utility.h"
@interface SettingViewController ()

@end

@implementation SettingViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view.
    
    // get the user info
    self.lbl_UserName.text = [Utility getUsername];
    
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (BOOL)shouldAutorotate
{
    return NO;
}

- (IBAction)Logout:(id)sender {
    // clear the user info
    [Utility clearUserInfo];
    
    [self performSegueWithIdentifier:@"DoLogout" sender:self];
}

@end
