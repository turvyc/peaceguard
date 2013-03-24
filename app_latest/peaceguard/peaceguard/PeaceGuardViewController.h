//
//  PeaceGuardViewController.h
//
//  Contributor(s): Ashley Lesperance
//
//  Copyright (c) 2013 Number 123 Developer's Group
//


#import <UIKit/UIKit.h>

#import "User.h"
#import "ConnectionDataController.h"
#import "ReportDataController.h"
#import <CoreLocation/CoreLocation.h>
//#import "UserDataController.h"

@class UserDataController;

@interface PeaceGuardViewController : UIViewController <UITextFieldDelegate>

@property (weak, nonatomic) IBOutlet UIWebView *help;
@property (weak, nonatomic) IBOutlet UITextField *username;
@property (weak, nonatomic) IBOutlet UITextField *password;
//@property(strong, nonatomic) UserDataController *userController;
@property (strong, nonatomic) User *user;
@property(nonatomic,retain) CLLocationManager *locationManager;
@property (strong, nonatomic) ConnectionDataController *connectionManager;
@property (weak, nonatomic) IBOutlet UIButton *Login;
@property(nonatomic) CGPoint originalCenter;
@property (strong, nonatomic) IBOutlet UIImageView *logoImage;

- (IBAction)Login:(id)sender;
- (void) deviceLocation;
//- (BOOL)logUsername: (NSString *) username password: (NSString *) password;
@end
