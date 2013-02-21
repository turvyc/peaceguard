//
//  ReportViewController.h
//  peaceguard
//
//  Created by JonasYao on 2013-02-15.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface ReportViewController : UIViewController

@property(strong, nonatomic) ReportViewController *reportController;
@property (weak, nonatomic) IBOutlet UIButton *submit;
- (IBAction) submitAction:(id)sender;
- (BOOL) verify: (NSString*) description;
@property (weak, nonatomic) IBOutlet UITextField *description;

@end
