//
//  PeaceGuardViewController.h
//
//  Contributor(s): Ashley Lesperance
//
//  Copyright (c) 2013 Number 123 Developer's Group
//


#import <UIKit/UIKit.h>
#import "ReportViewController.h"
#import "User.h"
//#import "UserDataController.h"

@class UserDataController;

@interface PeaceGuardViewController : UIViewController <UITextFieldDelegate>

@property (weak, nonatomic) IBOutlet UIWebView *help;
@property (weak, nonatomic) IBOutlet UITextField *username;
@property (weak, nonatomic) IBOutlet UITextField *password;
//@property(strong, nonatomic) UserDataController *userController;
@property (strong, nonatomic) User *user;
@property (weak, nonatomic) IBOutlet UIButton *Login;

- (IBAction)Login:(id)sender;
- (BOOL)logUsername: (NSString *) username password: (NSString *) password;
@end
