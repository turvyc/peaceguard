//
//  MainViewController.h
//
//  Contributor(s): Robert Sanchez
//
//  Copyright (c) 2013 Number 13 Developer's Group
//

#import <UIKit/UIKit.h>

@interface MainViewController : UIViewController


- (IBAction)patrolButton:(id)sender;
- (IBAction)statisticsButton:(id)sender;
- (IBAction)reportButton:(id)sender;

@property (strong, nonatomic) IBOutlet UIImageView *mainBackground;


@property(nonatomic) NSString *usernameData;

@property(nonatomic) NSString *segueType;

@end
