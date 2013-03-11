//
//  OverviewController.h
//  peaceguard
//
//  Created by Robert Sanchez on 2013-03-10.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface OverviewController : UIViewController

@property (strong, nonatomic) IBOutlet UILabel *incidentDisplay;
@property (strong, nonatomic) IBOutlet UILabel *severityDisplay;
@property (strong, nonatomic) IBOutlet UITextField *descriptionDisplay;
@property (strong, nonatomic) IBOutlet UIImageView *imageDisplay;

@property(nonatomic) NSString *incidentData;
@property(nonatomic) NSString *severityData;
@property(nonatomic) NSString *descriptionData;
@property(nonatomic) UIImage *imageData;

- (IBAction)cancelPressed:(id)sender;

@end