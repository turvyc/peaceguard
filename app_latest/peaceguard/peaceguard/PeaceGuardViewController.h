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
#import "MainViewController.h"
#import <CoreLocation/CoreLocation.h>

@class UserDataController;

@interface PeaceGuardViewController : UIViewController <UITextFieldDelegate>

//Properties
//UI Properties
@property (weak, nonatomic) IBOutlet UIWebView *help;
@property (weak, nonatomic) IBOutlet UITextField *username;
@property (weak, nonatomic) IBOutlet UITextField *password;
@property (weak, nonatomic) IBOutlet UIButton *Login;
@property (strong, nonatomic) IBOutlet UIImageView *logoImage;
@property(nonatomic) CGPoint originalCenter;
//Location property
@property(nonatomic,retain) CLLocationManager *locationManager;
//Custom classes
@property (strong, nonatomic) User *user;
@property (strong, nonatomic) ConnectionDataController *connectionManager;

//Methods
- (IBAction)Login:(id)sender;
- (void) deviceLocation;

@end
