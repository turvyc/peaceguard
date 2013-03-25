//
//  BadgesViewController.h
//
//  Contributor(s): Ashley Lesperance, Robert Sanchez
//
//  Copyright (c) 2013 Number 13 Developer's Group
//

#import <UIKit/UIKit.h>
#import "ConnectionDataController.h"

@interface BadgesViewController : UIViewController

//badge blockers
@property (strong, nonatomic) IBOutlet UIView *oneHour;
@property (strong, nonatomic) IBOutlet UIView *fiveHour;
@property (strong, nonatomic) IBOutlet UIView *tenHour;
@property (strong, nonatomic) IBOutlet UIView *oneKM;
@property (strong, nonatomic) IBOutlet UIView *fiveKM;
@property (strong, nonatomic) IBOutlet UIView *tenKM;

//Badge storage
@property (strong, nonatomic) NSDictionary *badgesDictionary;

//Connection to the server
@property (strong, nonatomic) ConnectionDataController *connectionManager;

//Navigation control
- (IBAction)returnToStats:(id)sender;

@end
