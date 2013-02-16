//
//  PeaceGuardViewController.h
//  peaceguard
//
//  Created by Lesperance Ashley on 2013-02-13.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "ReportViewController.h"
//#import "User.h"
#import "UserDataController.h"

@class UserDataController;

@interface PeaceGuardViewController : UIViewController <UITextFieldDelegate>

@property (weak, nonatomic) IBOutlet UITextField *username;
@property (weak, nonatomic) IBOutlet UITextField *password;
@property(strong, nonatomic) UserDataController *userController;
@property (weak, nonatomic) IBOutlet UIButton *Login;

- (IBAction)Login:(id)sender;
- (BOOL)logUsername: (NSString *) username andPassword: (NSString *) password;
@end
