//
//  MainViewController.h
//  peaceguard
//
//  Created by Robert Sanchez on 2013-03-12.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
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
