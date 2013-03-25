//
//  BadgesViewController.h
//  peaceguard
//
//  Created by Lesperance Ashley on 2013-03-24.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface BadgesViewController : UIViewController

//badge blockers
@property (strong, nonatomic) IBOutlet UIView *oneHour;
@property (strong, nonatomic) IBOutlet UIView *fiveHour;
@property (strong, nonatomic) IBOutlet UIView *tenHour;
@property (strong, nonatomic) IBOutlet UIView *oneKM;
@property (strong, nonatomic) IBOutlet UIView *fiveKM;
@property (strong, nonatomic) IBOutlet UIView *tenKM;

- (IBAction)returnToStats:(id)sender;

@end
